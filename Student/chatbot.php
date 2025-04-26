<?php
// chatbot.php
$API_KEY = 'AIzaSyC-5_63_A0t2--Nb8zKxGPsmbUi-TSDCKs';

session_start();

// Handle API requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    try {
        if (isset($_POST['action'])) {
            switch($_POST['action']) {
                case 'init':
                    $_SESSION['ec_initialized'] = true;
                    echo json_encode([
                        'success' => true,
                        'content' => "Welcome to E-SAFRA AI! 🎓 How can I assist you with learning today?"
                    ]);
                    break;
                    
                case 'send':
                    if (!empty($_POST['message'])) {
                        $response = generateContent($_POST['message'], $API_KEY);
                        echo json_encode(['success' => true, 'content' => $response]);
                    }
                    break;
            }
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

function generateContent($message, $apiKey) {
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';
    
    $data = [
        'contents' => [
            [
                'role' => 'user',
                'parts' => [
                    ['text' => "You are E-SAFRA AI, an educational assistant. Focus on learning, education, and technology. Be concise and helpful.\n\nUser: " . $message]
                ]
            ]
        ],
        'safetySettings' => [
            [
                'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                'threshold' => 'BLOCK_ONLY_HIGH'
            ]
        ]
    ];

    $ch = curl_init("$url?key=$apiKey");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        throw new Exception('API request failed: ' . curl_error($ch));
    }
    
    $responseData = json_decode($response, true);
    curl_close($ch);
    
    if ($httpCode !== 200) {
        throw new Exception($responseData['error']['message'] ?? 'API Error: ' . $httpCode);
    }
    
    return $responseData['candidates'][0]['content']['parts'][0]['text'];
}

function parseMessageContent($content) {
    $formatted = htmlspecialchars($content);
    
    // Headers
    $formatted = preg_replace('/^##### (.*+)/m', '<h5 class="ec-heading ec-h5">$1</h5>', $formatted);
    $formatted = preg_replace('/^#### (.*+)/m', '<h4 class="ec-heading ec-h4">$1</h4>', $formatted);
    $formatted = preg_replace('/^### (.*+)/m', '<h3 class="ec-heading ec-h3">$1</h3>', $formatted);
    $formatted = preg_replace('/^## (.*+)/m', '<h2 class="ec-heading ec-h2">$1</h2>', $formatted);
    $formatted = preg_replace('/^# (.*+)/m', '<h1 class="ec-heading ec-h1">$1</h1>', $formatted);
    
    // Lists
    $formatted = preg_replace('/\n\s*[-*+] (.*+)/', "\n<li class='ec-list-item'>$1</li>", $formatted);
    $formatted = preg_replace('/(<li class=\'ec-list-item\'>.*<\/li>)+/s', '<ul class="ec-unordered-list">$0</ul>', $formatted);
    
    // Text formatting
    $formatted = preg_replace('/\*\*\*(.*?)\*\*\*/s', '<strong class="ec-bold"><em class="ec-italic">$1</em></strong>', $formatted);
    $formatted = preg_replace('/\*\*(.*?)\*\*/', '<strong class="ec-bold">$1</strong>', $formatted);
    $formatted = preg_replace('/\*(.*?)\*/', '<em class="ec-italic">$1</em>', $formatted);
    
    // Code blocks
    $formatted = preg_replace_callback('/```(\w+)?\s*([\s\S]*?)```/', function($matches) {
        $lang = $matches[1] ?? '';
        return '<div class="ec-code-block"><div class="ec-code-header">'.($lang ?: 'code').'</div><pre><code class="ec-code '.$lang.'">'.htmlspecialchars($matches[2]).'</code></pre></div>';
    }, $formatted);
    
    $formatted = preg_replace('/`(.*?)`/', '<code class="ec-inline-code">$1</code>', $formatted);
    
    // Paragraphs and line breaks
    $formatted = nl2br($formatted);
    $formatted = preg_replace('/(<br>){3,}/', '</p><p class="ec-paragraph">', $formatted);
    $formatted = '<div class="ec-content">'.preg_replace('/^(.*+)$/m', '$1', $formatted).'</div>';
    
    return $formatted;
}
?>
<style>
.ec-chatbot {
    --ec-primary: #000000;
    --ec-secondary: #e3b500;
    --ec-background: #ffffff;
    --ec-text: #333333;
    --ec-border: 1px solid rgba(0,0,0,0.1);
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    all: initial;
}

.ec-chatbot * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.ec-container {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 10000;
}

.ec-toggle-btn {
    background: var(--ec-primary);
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.ec-toggle-btn:hover {
    transform: scale(1.1) rotate(15deg);
}

.ec-toggle-btn svg {
    width: 28px;
    height: 28px;
    fill: #ffffff;
}

.ec-window {
    width: 450px;
    height: 600px;
    background: var(--ec-background);
    border-radius: 20px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
    border: 2px solid var(--ec-primary);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transform: translateY(120%);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    position: absolute;
    bottom: 0px;
    right: 0;
}

.ec-window.open {
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
}

.ec-header {
    background: var(--ec-primary);
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.ec-brand {
    display: flex;
    align-items: center;
    gap: 12px;
}

.ec-logo {
    width: 36px;
    height: 36px;
    fill: var(--ec-secondary);
}

.ec-title {
    color: #ffffff;
    font-size: 1.25rem;
    font-weight: 600;
}

.ec-close-btn {
    background: none;
    border: none;
    padding: 8px;
    cursor: pointer;
    color: #ffffff;
    transition: transform 0.2s ease;
    color: white;
    background-color: white;
    border-radius: 50%;
}

.ec-close-btn:hover {
    transform: rotate(90deg);
}

.ec-close-btn svg {
    width: 24px;
    height: 24px;
    color: white;
}

.ec-messages {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: #f8f9fa;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.ec-message {
    max-width: 85%;
    padding: 16px 20px;
    border-radius: 20px;
    font-size: 0.95rem;
    line-height: 1.6;
    position: relative;
}

.ec-message.user {
    background: var(--ec-primary);
    color: #ffffff;
    align-self: flex-end;
    border-radius: 20px 20px 5px 20px;
}

.ec-message.bot {
    background: #ffffff;
    color: var(--ec-text);
    align-self: flex-start;
    border-radius: 5px 20px 20px 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    padding-left: 50px;
}

.ec-message.bot::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 16px;
    width: 28px;
    height: 28px;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23e3b500"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-3.5-6.5h7v-1h-7zm0-3h7v-1h-7z"/></svg>');
}

.ec-form {
    padding: 16px;
    background: #ffffff;
    border-top: var(--ec-border);
    display: flex;
    gap: 12px;
    align-items: center;
}

.ec-input {
    flex: 1;
    padding: 14px 18px;
    border: 2px solid #e0e0e0;
    border-radius: 15px;
    resize: none;
    min-height: 50px;
    max-height: 120px;
    font-size: 0.95rem;
    line-height: 1.5;
}

.ec-input:focus {
    outline: none;
    border-color: var(--ec-secondary);
    box-shadow: 0 0 0 3px rgba(227, 181, 0, 0.1);
}

.ec-send-btn {
    background: var(--ec-primary);
    border: none;
    border-radius: 15px;
    width: 50px;
    height: 50px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease;
}

.ec-send-btn:hover {
    background: var(--ec-secondary);
}

.ec-send-btn svg {
    width: 22px;
    height: 22px;
    fill: #ffffff;
}

.ec-typing {
    color: #666;
    padding: 12px 18px;
    background: rgba(227, 181, 0, 0.1);
    border-radius: 18px;
    align-self: flex-start;
    font-size: 0.9em;
    display: inline-flex;
    gap: 8px;
    align-items: center;
}

.ec-dot-flashing {
    position: relative;
    width: 8px;
    height: 8px;
    border-radius: 4px;
    background-color: var(--ec-secondary);
    color: var(--ec-secondary);
    animation: ec-dotFlashing 1s infinite linear;
}

@keyframes ec-dotFlashing {
    0% { opacity: 0.2; }
    50% { opacity: 1; }
    100% { opacity: 0.2; }
}

.ec-code-block {
    margin: 1rem 0;
    border-radius: 8px;
    overflow: hidden;
}

.ec-code-header {
    background: rgba(0,0,0,0.05);
    padding: 8px 12px;
    font-family: 'Fira Code', monospace;
    font-size: 0.85em;
    color: var(--ec-text);
}

.ec-code {
    background: #1a1a1a;
    color: #f8f8f8;
    padding: 1rem;
    font-family: 'Fira Code', monospace;
    font-size: 0.9rem;
    overflow-x: auto;
}

.ec-inline-code {
    background: rgba(0,0,0,0.05);
    padding: 0.2em 0.4em;
    border-radius: 4px;
    font-family: 'Fira Code', monospace;
    font-size: 0.9em;
}

.ec-paragraph {
    margin: 0.75rem 0;
}

.ec-heading {
    margin: 1.25rem 0 0.75rem;
    font-weight: 600;
}

.ec-h1 { font-size: 1.5rem; }
.ec-h2 { font-size: 1.3rem; }
.ec-h3 { font-size: 1.1rem; }
.ec-h4 { font-size: 1rem; }
.ec-h5 { font-size: 0.9rem; }

.ec-bold { font-weight: 700; }
.ec-italic { font-style: italic; }

.ec-unordered-list {
    padding-left: 1.5rem;
    margin: 0.75rem 0;
    list-style-type: disc;
}

.ec-list-item {
    margin: 0.5rem 0;
}
</style>

<div class="ec-chatbot">
    <div class="ec-container">
        <button class="ec-toggle-btn" id="ecToggle">
            <svg viewBox="0 0 24 24">
                <path d="M19 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-3 15H8c-.55 0-1-.45-1-1s.45-1 1-1h8c.55 0 1 .45 1 1s-.45 1-1 1zm0-4H8c-.55 0-1-.45-1-1s.45-1 1-1h8c.55 0 1 .45 1 1s-.45 1-1 1zm0-4H8c-.55 0-1-.45-1-1s.45-1 1-1h8c.55 0 1 .45 1 1s-.45 1-1 1z"/>
            </svg>
        </button>

        <div class="ec-window" id="ecWindow">
            <div class="ec-header">
                <div class="ec-brand">
                    <svg class="ec-logo" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-3.5-6.5h7v-1h-7zm0-3h7v-1h-7z"/>
                    </svg>
                    <h3 class="ec-title">E-SAFRA AI</h3>
                </div>
                <button class="ec-close-btn" id="ecClose">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </button>
            </div>

            <div class="ec-messages" id="ecMessages"></div>

            <form class="ec-form" id="ecForm">
                <textarea class="ec-input" id="ecInput" placeholder="Type your message..." 
                        onkeydown="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); this.form.requestSubmit(); }"></textarea>
                <button type="submit" class="ec-send-btn">
                    <svg viewBox="0 0 24 24">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const ecChatbot = document.querySelector('.ec-chatbot');
    const ecToggle = document.getElementById('ecToggle');
    const ecWindow = document.getElementById('ecWindow');
    const ecForm = document.getElementById('ecForm');
    const ecInput = document.getElementById('ecInput');
    const ecMessages = document.getElementById('ecMessages');
    let isInitialized = sessionStorage.getItem('ecInitialized');

    // Initialize chat on first interaction
    if (!isInitialized) {
        setTimeout(initializeChat, 500);
    }

    // Toggle window visibility
    ecToggle.addEventListener('click', () => ecWindow.classList.toggle('open'));
    document.getElementById('ecClose').addEventListener('click', () => ecWindow.classList.remove('open'));

    // Handle form submission
    ecForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = ecInput.value.trim();
        if (!message) return;

        // Add user message
        addMessage(message, 'user');
        ecInput.value = '';
        
        // Show typing indicator
        const typing = document.createElement('div');
        typing.className = 'ec-message bot ec-typing';
        typing.innerHTML = `
            <div class="ec-dot-flashing"></div>
            E-SAFRA AI is typing...
        `;
        ecMessages.appendChild(typing);
        ecMessages.scrollTop = ecMessages.scrollHeight;

        try {
            const response = await fetch('chatbot.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'send',
                    message: message
                })
            });

            const data = await response.json();
            typing.remove();
            
            if (data.success) {
                addMessage(data.content, 'bot');
            } else {
                addMessage(data.error || 'An error occurred', 'bot');
            }
        } catch (error) {
            typing.remove();
            addMessage('Failed to connect to the server', 'bot');
        }
    });

    // Auto-resize textarea
    ecInput.addEventListener('input', () => {
        ecInput.style.height = 'auto';
        ecInput.style.height = ecInput.scrollHeight + 'px';
    });

    async function initializeChat() {
        try {
            const response = await fetch('chatbot.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ action: 'init' })
            });

            const data = await response.json();
            if (data.success) {
                addMessage(data.content, 'bot');
                sessionStorage.setItem('ecInitialized', 'true');
            }
        } catch (error) {
            addMessage('Failed to initialize chat session', 'bot');
        }
    }

    function addMessage(content, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `ec-message ${type}`;
        messageDiv.innerHTML = `<?php echo addslashes(parseMessageContent('${content}')) ?>`;
        ecMessages.appendChild(messageDiv);
        applySyntaxHighlighting();
        ecMessages.scrollTop = ecMessages.scrollHeight;
    }

    function applySyntaxHighlighting() {
        document.querySelectorAll('.ec-code').forEach(block => {
            hljs.highlightElement(block);
        });
    }
});

// Load syntax highlighting
document.head.insertAdjacentHTML('beforeend', 
    '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.0/styles/default.min.css">'
);
const script = document.createElement('script');
script.src = 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.0/highlight.min.js';
script.onload = () => hljs.highlightAll();
document.head.appendChild(script);
</script>