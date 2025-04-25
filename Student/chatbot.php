<?php
// chatbot.php
$API_KEY = 'AIzaSyC-5_63_A0t2--Nb8zKxGPsmbUi-TSDCKs';

// Handle API request
if (isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    try {
        if ($_POST['action'] === 'send' && !empty($_POST['message'])) {
            $response = generateContent($_POST['message'], $API_KEY);
            echo json_encode(['success' => true, 'content' => $response]);
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
            'parts' => [
                ['text' => $message]
            ]
        ]
    ];

    $ch = curl_init("$url?key=$apiKey");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        throw new Exception('API request failed: ' . curl_error($ch));
    }
    
    curl_close($ch);
    
    $responseData = json_decode($response, true);
    if ($httpCode !== 200) {
        throw new Exception($responseData['error']['message'] ?? 'Unknown error');
    }
    
    return $responseData['candidates'][0]['content']['parts'][0]['text'];
}

function parseMessageContent($content) {
    $formatted = nl2br(htmlspecialchars($content));
    $formatted = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $formatted);
    $formatted = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $formatted);
    $formatted = preg_replace('/^# (.*)$/m', '<h3>$1</h3>', $formatted);
    $formatted = preg_replace('/^## (.*)$/m', '<h4>$1</h4>', $formatted);
    $formatted = preg_replace('/^### (.*)$/m', '<h5>$1</h5>', $formatted);
    $formatted = preg_replace('/```([\s\S]*?)```/', '<pre><code>$1</code></pre>', $formatted);
    $formatted = preg_replace('/`(.*?)`/', '<code>$1</code>', $formatted);
    return $formatted;
}
?>
<style>
:root {
    --primary-color: #e3b500;
    --secondary-color: #000000;
    --background-color: rgba(255, 255, 255, 0.95);
}

.chat-container {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 1000;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

.chat-button {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border: none;
    border-radius: 18px;
    width: 64px;
    height: 64px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(227, 181, 0, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.chat-button:hover {
    transform: scale(1.05) rotate(5deg);
    box-shadow: 0 12px 32px rgba(227, 181, 0, 0.4);
}

.chat-window {
    width: 380px;
    height: 600px;
    background: var(--background-color);
    border-radius: 20px;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    backdrop-filter: blur(12px);
    border: 2px solid var(--primary-color);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transform: translateY(120%);
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    visibility: hidden;
    position: absolute;
    bottom: 80px;
    right: 0;
}

.chat-window.open {
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
}

.header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 18px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid var(--primary-color);
}

.header h3 {
    font-weight: 700;
    letter-spacing: 0.5px;
}

.messages-container {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: rgba(248, 250, 252, 0.6);
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.message {
    background: rgba(227, 181, 0, 0.1);
    color: #000;
    padding: 14px 18px;
    border-radius: 18px 18px 18px 4px;
    max-width: 85%;
    align-self: flex-start;
    word-wrap: break-word;
    border: 1px solid rgba(227, 181, 0, 0.2);
}

.message.user {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    border-radius: 18px 18px 4px 18px;
    align-self: flex-end;
    border: none;
}

.message-form {
    display: flex;
    align-items: center;
    padding: 16px;
    gap: 12px;
    background: rgba(255, 255, 255, 0.9);
    border-top: 2px solid rgba(227, 181, 0, 0.1);
}

.message-input {
    flex: 1;
    padding: 14px 18px;
    border: 2px solid rgba(227, 181, 0, 0.3);
    border-radius: 14px;
    resize: none;
    min-height: 48px;
    max-height: 120px;
    background: rgba(255, 255, 255, 0.9);
}

.message-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(227, 181, 0, 0.1);
}

.send-button {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border: none;
    border-radius: 14px;
    width: 48px;
    height: 48px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.send-button:hover {
    opacity: 0.9;
}

.typing-indicator {
    color: #666;
    padding: 12px 18px;
    background: rgba(227, 181, 0, 0.1);
    border-radius: 18px;
    align-self: flex-start;
    font-size: 0.9em;
}
</style>

<div class="chat-container">
    <button class="chat-button" id="chatToggle">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
    </button>

    <div class="chat-window" id="chatWindow">
        <div class="header">
            <h3>E-SAFRA AI</h3>
            <button class="close-button" id="closeChat">×</button>
        </div>

        <div class="messages-container" id="messagesContainer"></div>

        <form class="message-form" id="messageForm">
            <textarea class="message-input" id="messageInput" placeholder="Type your message..."></textarea>
            <button type="submit" class="send-button" id="sendButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"/>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatToggle = document.getElementById('chatToggle');
    const chatWindow = document.getElementById('chatWindow');
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const messagesContainer = document.getElementById('messagesContainer');

    chatToggle.addEventListener('click', () => chatWindow.classList.toggle('open'));
    document.getElementById('closeChat').addEventListener('click', () => chatWindow.classList.remove('open'));

    messageForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;

        // Add user message
        addMessage(message, 'user');
        messageInput.value = '';
        
        // Add typing indicator
        const typing = document.createElement('div');
        typing.className = 'typing-indicator';
        typing.textContent = 'E-SAFRA AI is typing...';
        messagesContainer.appendChild(typing);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        try {
            const response = await fetch('chatbot.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ action: 'send', message })
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

    function addMessage(content, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}`;
        messageDiv.innerHTML = `<?php echo addslashes(parseMessageContent('${content}')) ?>`;
        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});
</script>