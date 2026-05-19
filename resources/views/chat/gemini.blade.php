<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat IA - Gemini</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #fff1f7 0%, #fde6f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .chat {
            width: 100%;
            max-width: 720px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,.08);
            display: flex;
            flex-direction: column;
            height: 80vh;
            overflow: hidden;
        }
        .chat-header {
            padding: 18px 22px;
            background: linear-gradient(90deg, #ff4f9a, #a855f7);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .chat-header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        .chat-header small {
            opacity: .85;
            font-size: 12px;
        }
        .messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #fafafa;
        }
        .msg {
            display: flex;
            margin-bottom: 12px;
        }
        .msg .bubble {
            max-width: 75%;
            padding: 10px 14px;
            border-radius: 14px;
            line-height: 1.45;
            font-size: 14px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .msg.user { justify-content: flex-end; }
        .msg.user .bubble {
            background: #ff4f9a;
            color: white;
            border-bottom-right-radius: 4px;
        }
        .msg.model .bubble {
            background: white;
            border: 1px solid #eee;
            color: #333;
            border-bottom-left-radius: 4px;
        }
        .msg.error .bubble {
            background: #fee;
            color: #c00;
            border: 1px solid #fcc;
        }
        .typing {
            font-size: 13px;
            color: #999;
            font-style: italic;
            padding: 0 20px 8px;
            min-height: 22px;
        }
        form {
            padding: 14px;
            border-top: 1px solid #eee;
            display: flex;
            gap: 8px;
            background: white;
        }
        textarea {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
            resize: none;
            font-family: inherit;
            outline: none;
            transition: border .2s;
        }
        textarea:focus { border-color: #ff4f9a; }
        button {
            background: linear-gradient(90deg, #ff4f9a, #a855f7);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0 18px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity .2s;
        }
        button:disabled { opacity: .5; cursor: not-allowed; }
        .warning {
            margin: 12px 20px 0;
            padding: 10px 14px;
            background: #fff3cd;
            color: #856404;
            border-radius: 8px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="chat">
        <div class="chat-header">
            <h1>Chat IA</h1>
            <small>{{ $model }}</small>
        </div>

        @unless($configured)
            <div class="warning">
                GEMINI_API_KEY no esta configurada en .env, las respuestas no funcionaran.
            </div>
        @endunless

        <div class="messages" id="messages">
            <div class="msg model">
                <div class="bubble">Hola, soy tu asistente. Preguntame lo que necesites.</div>
            </div>
        </div>

        <div class="typing" id="typing"></div>

        <form id="chat-form">
            <textarea id="input" rows="2" placeholder="Escribe tu mensaje..." required></textarea>
            <button type="submit" id="send">Enviar</button>
        </form>
    </div>

    <script>
        const form = document.getElementById('chat-form');
        const input = document.getElementById('input');
        const messages = document.getElementById('messages');
        const typing = document.getElementById('typing');
        const sendBtn = document.getElementById('send');
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        const history = [];

        function addMessage(role, text) {
            const div = document.createElement('div');
            div.className = 'msg ' + role;
            const bubble = document.createElement('div');
            bubble.className = 'bubble';
            bubble.textContent = text;
            div.appendChild(bubble);
            messages.appendChild(div);
            messages.scrollTop = messages.scrollHeight;
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = input.value.trim();
            if (!message) return;

            addMessage('user', message);
            input.value = '';
            sendBtn.disabled = true;
            typing.textContent = 'Gemini esta escribiendo...';

            try {
                const res = await fetch('{{ route('chat.gemini.send') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: JSON.stringify({ message, history }),
                });

                const data = await res.json();

                if (!res.ok) {
                    addMessage('error', data.message || 'Error al consultar Gemini.');
                } else {
                    const reply = data.reply || '(sin respuesta)';
                    addMessage('model', reply);
                    history.push({ role: 'user', text: message });
                    history.push({ role: 'model', text: reply });
                }
            } catch (err) {
                addMessage('error', 'Error de red: ' + err.message);
            } finally {
                typing.textContent = '';
                sendBtn.disabled = false;
                input.focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                form.requestSubmit();
            }
        });
    </script>
</body>
</html>
