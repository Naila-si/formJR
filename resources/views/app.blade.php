<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MOVEON • Portal Petugas</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <style>
    :root{
      --bg:#e6f4ff;--panel:#ffffff;--panel-soft:#f4faff;
      --ink:#0f172a;--muted:#334155;
      --brand:#2563eb;--brand-2:#3b82f6;
      --shadow:0 12px 28px rgba(37,99,235,.18);
      --radius:18px;
    }
    *{box-sizing:border-box}
    html,body{margin:0;padding:0}
    body{
      font-family:'Inter',system-ui,Segoe UI,Roboto,Helvetica,Arial;
      color:var(--ink);
      background:linear-gradient(135deg,#dbeafe 0%, var(--bg) 100%);
      -webkit-font-smoothing:antialiased; text-rendering:optimizeLegibility;
      animation:fadeIn .8s ease;
    }
    @keyframes fadeIn{from{opacity:0}to{opacity:1}}

    /* Header */
    header{position:sticky;top:0;z-index:40;background:rgba(255,255,255,.92);backdrop-filter:blur(8px);border-bottom:1px solid #dbeafe}
    .nav{max-width:1200px;margin:0 auto;padding:14px 20px;display:flex;align-items:center;justify-content:space-between;gap:16px}
    .brand{display:flex;align-items:center;gap:12px;font-weight:800;font-size:20px}
    .brand img{height:48px;animation:float 3s ease-in-out infinite}
    @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
    .nav-actions{display:flex;gap:10px}
    .btn{border:0;padding:10px 18px;border-radius:14px;font-weight:700;cursor:pointer;box-shadow:var(--shadow);transition:transform .25s ease,box-shadow .25s ease}
    .btn:hover{transform:translateY(-2px) scale(1.02);box-shadow:0 14px 34px rgba(37,99,235,.28)}
    .btn-ghost{background:#f1f5f9;color:#0f172a;border:1px solid #dbeafe}
    .btn-primary{background:linear-gradient(90deg,var(--brand),var(--brand-2));color:#fff}

    /* Hero layout */
    .hero{max-width:1200px;margin:32px auto;padding:0 20px;display:grid;grid-template-columns:1fr 1fr;gap:28px;align-items:stretch}
    .lead{background:var(--panel);border:1px solid #dbeafe;border-radius:var(--radius);box-shadow:var(--shadow);padding:32px;animation:slideUp .9s ease forwards;opacity:0;transform:translateY(32px)}
    @keyframes slideUp{to{opacity:1;transform:translateY(0)}}
    .lead h1{font-size:clamp(26px,4vw,48px);margin:0 0 10px;font-weight:800;color:var(--brand)}
    .lead p{color:var(--muted);margin:0 0 18px;font-size:clamp(14px,2.3vw,17px)}
    .actions{display:grid;gap:16px}
    .action-card{display:flex;align-items:center;gap:16px;background:var(--panel-soft);border:1px solid #dbeafe;border-radius:16px;padding:18px;box-shadow:var(--shadow);cursor:pointer;transition:transform .22s ease, box-shadow .22s ease}
    .action-card:hover{transform:translateY(-3px) scale(1.015);box-shadow:0 14px 32px rgba(37,99,235,.28)}
    .action-card .icon{width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:32px;color:#fff;background:linear-gradient(135deg,var(--brand),var(--brand-2));animation:pulse 2.1s infinite}
    @keyframes pulse{0%,100%{box-shadow:0 0 0 0 rgba(37,99,235,.5)}50%{box-shadow:0 0 0 14px rgba(37,99,235,0)}}
    .title{font-size:18px;font-weight:800}
    .hint{font-size:13px;color:var(--muted)}

    /* Mascot panel */
    .aside{display:grid;align-content:start}
    .mascot{background:#eaf6ff;border:1px solid #cfe9ff;border-radius:18px;padding:24px;text-align:center;box-shadow:var(--shadow);animation:slideUp 1.1s ease .05s both}
    .mascot img{height:min(280px,38vw);max-width:100%;object-fit:contain;margin-bottom:14px;animation:float 3s ease-in-out infinite}
    .mascot h2{margin:0 0 6px;font-size:clamp(18px,3.8vw,22px)}

    footer{max-width:1200px;margin:36px auto;padding:0 20px 30px;text-align:center;color:var(--muted);font-size:12px}

    /* Chatbot Floating */
    .chat-fab{position:fixed;right:18px;bottom:18px;width:60px;height:60px;border-radius:50%;display:grid;place-items:center;background:linear-gradient(135deg,var(--brand),var(--brand-2));color:#fff;box-shadow:0 14px 30px rgba(37,99,235,.35);cursor:pointer;animation:pulse 2.2s infinite;z-index:60}
    .chat-fab .badge{position:absolute;top:-6px;right:-6px;min-width:20px;height:20px;padding:0 6px;border-radius:999px;background:#ef4444;color:#fff;font-size:12px;display:none;align-items:center;justify-content:center}
    .chat-window{position:fixed;right:18px;bottom:86px;width:388px;max-width:92vw;background:#fff;border:1px solid #dbeafe;border-radius:16px;box-shadow:var(--shadow);display:none;z-index:60}
    .chat-window.open{display:grid;grid-template-rows:auto auto 1fr auto;max-height:78vh}
    .chat-head{background:linear-gradient(90deg,var(--brand),var(--brand-2));color:#fff;padding:10px 12px;display:flex;align-items:center;justify-content:space-between;gap:8px}
    .head-actions{display:flex;gap:6px}
    .head-btn{background:#ffffff22;border:1px solid #ffffff55;color:#fff;border-radius:8px;padding:6px 10px;cursor:pointer}
    .faq-bar{display:flex;gap:8px;flex-wrap:wrap;padding:10px;background:#f4faff;border-bottom:1px solid #e2e8f0}
    .chip{border:1px solid #dbeafe;background:#eef6ff;color:#0f172a;font-size:12px;padding:8px 10px;border-radius:999px;cursor:pointer}
    .chip:hover{background:#e3f0ff}
    .chat-body{padding:12px;display:grid;gap:8px;overflow:auto;background:var(--panel-soft)}
    .msg{padding:10px 12px;border-radius:12px;font-size:13px;line-height:1.4;word-wrap:break-word}
    .bot{background:#e0edff;border:1px solid #c7dbff}
    .me{background:#dcfce7;border:1px solid #bbf7d0;justify-self:end}
    .chat-input{display:flex;gap:8px;padding:10px;background:#fff;border-top:1px solid #e2e8f0}
    .chat-input input{flex:1;padding:10px 12px;border-radius:10px;border:1px solid #dbeafe}
    .chat-input button{padding:10px 14px;border:0;border-radius:10px;background:var(--brand);color:#fff;font-weight:800}

    @media (max-width:1024px){.hero{gap:20px}.action-card .icon{width:56px;height:56px;font-size:28px}}
    @media (max-width:768px){
      .hero{grid-template-columns:1fr;gap:18px}
      .lead{padding:22px}
      .actions{gap:14px}
      .action-card{padding:16px}
      .brand img{height:42px}
      .chat-window{right:12px;bottom:80px}
      .chat-fab{right:12px;bottom:12px}
    }
    @media (max-width:480px){
      .action-card .icon{width:52px;height:52px;font-size:26px}
      .title{font-size:16px}
      .hint{font-size:12px}
      .chat-window.open{max-height:72vh}
      .chat-input button{font-weight:700}
    }
    @media (prefers-reduced-motion: reduce){*{animation:none !important;transition:none !important}}
  </style>
</head>
<body>
  <header>
    <nav class="nav">
      <div class="brand">
        <img src="{{ asset('images/logo.png') }}" alt="Logo MOVEON" />
        <span>MOVEON</span>
      </div>
      <div class="nav-actions">
        <a href="{{ route('login') }}" class="btn btn-ghost">Login</a>
        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
      </div>
    </nav>
  </header>

  <main class="hero" role="main">
    <section class="lead" aria-labelledby="welcomeTitle">
      <h1 id="welcomeTitle">Selamat datang di MOVEON</h1>
      <p>Sistem digital modern untuk petugas. Kelola data dengan cepat, aman, dan interaktif.</p>

      <div class="actions" aria-label="Menu utama">
        <div class="action-card" role="button" tabindex="0" onclick="redirectTo('{{ route('formulir.index') }}')" onkeypress="handleKey(event, '{{ route('formulir.index') }}')">
          <div class="icon" aria-hidden="true"><span class="material-icons">directions_car</span></div>
          <div><div class="title">Form CRM</div><div class="hint">Input & kelola data kendaraan</div></div>
        </div>
        <div class="action-card" role="button" tabindex="0" onclick="redirectTo('{{ route('manifest.index') }}')" onkeypress="handleKey(event, '{{ route('manifest.index') }}')">
          <div class="icon" aria-hidden="true"><span class="material-icons">directions_boat</span></div>
          <div><div class="title">Form Manifest</div><div class="hint">Isi data manifest kapal</div></div>
        </div>
      </div>
    </section>

    <aside class="aside" aria-label="Informasi & maskot">
      <div class="mascot">
        <img src="{{ asset('images/logo moveon.png') }}" alt="Maskot MOVEON" />
        <h2>MOVEON siap mendukung</h2>
        <p class="hint">Gunakan layanan dengan mudah & nikmati pengalaman digital interaktif</p>
      </div>
    </aside>
  </main>

  <footer>
    © <span id="y"></span> MOVEON — Sistem Digital untuk Petugas Transportasi.
  </footer>

  <!-- Chatbot Floating -->
  <button class="chat-fab" id="chatFab" aria-label="Buka chat bot">
    <span class="material-icons" aria-hidden="true">chat</span>
    <span class="badge" id="unreadBadge">0</span>
  </button>

  <div class="chat-window" id="chatWin" role="dialog" aria-modal="true" aria-labelledby="chatTitle">
    <div class="chat-head">
      <strong id="chatTitle">MOVEON Chatbot</strong>
      <div class="head-actions">
        <button class="head-btn" id="soundBtn" title="Matikan/aktifkan suara" aria-label="Toggle notifikasi suara">
          <span class="material-icons" id="soundIcon">notifications_active</span>
        </button>
        <button class="head-btn" onclick="toggleChat(false)" aria-label="Tutup chat">
          <span class="material-icons">close</span>
        </button>
      </div>
    </div>

    <div class="faq-bar" id="faqBar" aria-label="FAQ cepat"></div>

    <div class="chat-body" id="chatBody">
      <div class="msg bot">Halo! Saya bot MOVEON. Tanyakan seputar <b>Form CRM</b>, <b>Form Manifest</b>, login, jam operasional, atau pilih FAQ di atas.</div>
    </div>
    <div class="chat-input">
      <input id="chatInput" type="text" placeholder="Tulis pesan... (cth: cara isi form manifest)" aria-label="Isi pesan chatbot" />
      <button id="sendBtn" aria-label="Kirim pesan">Kirim</button>
    </div>
  </div>

  <!-- AUDIO: notifikasi suara (pastikan file ada di public/audio/...) -->
  <audio id="notifAudio" src="{{ asset('audio/1758696117553560406gp0a4po-voicemaker.in-speech.mp3') }}" preload="auto"></audio>

  <script>
    // Util
    function redirectTo(url){ window.location.href = url; }
    function handleKey(e, url){ if(e.key === 'Enter' || e.key === ' '){ redirectTo(url); } }
    document.getElementById('y').textContent = new Date().getFullYear();

    // Chatbot refs
    const chatFab   = document.getElementById('chatFab');
    const chatWin   = document.getElementById('chatWin');
    const chatBody  = document.getElementById('chatBody');
    const chatInput = document.getElementById('chatInput');
    const faqBar    = document.getElementById('faqBar');
    const unreadBadge = document.getElementById('unreadBadge');
    const sendBtn   = document.getElementById('sendBtn');

    chatFab.addEventListener('click', () => toggleChat());

    function toggleChat(force){
      const open = force === undefined ? !chatWin.classList.contains('open') : force;
      if(open){
        chatWin.classList.add('open');
        clearUnread();
      }else{
        chatWin.classList.remove('open');
      }
    }

    // ===== Notifikasi Suara =====
    const notifAudio = document.getElementById('notifAudio');
    const soundBtn   = document.getElementById('soundBtn');
    const soundIcon  = document.getElementById('soundIcon');

    let soundEnabled   = JSON.parse(localStorage.getItem('moveon_sound') ?? 'true'); // default ON
    let userInteracted = false; // diperlukan agar play() bisa jalan (autoplay policy)

    // siapkan audio
    notifAudio.volume = 1.0;
    notifAudio.muted  = false;

    function updateSoundUI(){
      soundIcon.textContent = soundEnabled ? 'notifications_active' : 'notifications_off';
      soundBtn?.setAttribute('aria-pressed', soundEnabled ? 'false' : 'true');
    }
    updateSoundUI();

    function markInteracted(){
      if (userInteracted) return;
      userInteracted = true;
      // nudge: coba play-pause sekali supaya device “unlock”
      try { notifAudio.play().then(()=>notifAudio.pause()).catch(()=>{}); } catch(e){}
    }
    document.addEventListener('click',      markInteracted);
    document.addEventListener('keydown',    markInteracted);
    document.addEventListener('touchstart', markInteracted, {passive:true});

    // juga tandai saat buka chat / klik chip / klik kirim
    const _toggleChat = toggleChat;
    window.toggleChat = function(force){ markInteracted(); _toggleChat(force); };

    soundBtn?.addEventListener('click', () => {
      soundEnabled = !soundEnabled;
      localStorage.setItem('moveon_sound', JSON.stringify(soundEnabled));
      updateSoundUI();
    });

    function playNotify(){
      if (!soundEnabled || !userInteracted) return;
      try {
        notifAudio.currentTime = 0;
        notifAudio.play().catch(err => console.debug('Gagal play audio:', err));
      } catch (e) {
        console.debug('Exception play audio:', e);
      }
    }
    window.playNotify = playNotify;

    // Unread badge helper
    let unread = 0;
    function bumpUnread(){
      if(chatWin.classList.contains('open')) return;
      unread++;
      unreadBadge.style.display = 'flex';
      unreadBadge.textContent = String(unread);
    }
    function clearUnread(){
      unread = 0;
      unreadBadge.textContent = '0';
      unreadBadge.style.display = 'none';
    }

    // Q&A Preset
    const QA = [
      { triggers: ['halo','hai','assalamualaikum','pagi','siang','sore','malam'],
        reply: 'Halo! Selamat datang di MOVEON 👋 Ada yang bisa saya bantu?' },
      { triggers: ['terima kasih','makasih','thanks','thank you'],
        reply: 'Sama-sama 🙏 Senang bisa membantu Anda.' },
      { triggers: ['siapa kamu','kamu siapa','kamu bot apa'],
        reply: 'Saya <b>Chatbot MOVEON</b>, asisten digital untuk membantu petugas.' },
      { triggers: ['bantuan','help','butuh bantuan','panduan','manual'],
        reply: 'Silakan pilih menu <b>Form CRM</b> atau <b>Form Manifest</b>. Jika bingung, saya bisa arahkan langkah-langkahnya.' },
      { triggers: ['jam operasional','jam kerja','waktu layanan'],
        reply: 'MOVEON bisa diakses 24 jam. Dukungan admin: <b>08.00–17.00 WIB</b> (Senin–Jumat).' },
      { triggers: ['login','masuk akun'],
        reply: 'Klik tombol <b>Login</b> di kanan atas lalu masukkan kredensial Anda.' },
      { triggers: ['register','daftar akun','buat akun','sign up'],
        reply: 'Klik <b>Register</b> di kanan atas untuk membuat akun baru.' },
      { triggers: ['logout','keluar'],
        reply: 'Klik menu profil di kanan atas, lalu pilih <b>Logout</b>.' },
      { triggers: ['reset password','lupa password','ganti password'],
        reply: 'Untuk reset password: klik <b>Login</b> ➜ pilih <b>Lupa Password</b> ➜ ikuti instruksi di email.' },
      { triggers: ['form crm','crm','data kendaraan','kendaraan'],
        reply: 'Untuk mengisi <b>Form CRM</b>, klik kartu CRM di halaman utama. Pastikan data kendaraan (plat, jenis, dokumen) lengkap.' },
      { triggers: ['form manifest','manifest','status manifest','isi manifest'],
        reply: 'Untuk mengisi/cek <b>Form Manifest</b>, klik kartu Manifest di halaman utama dan lengkapi data penumpang & rute.' },
      { triggers: ['upload dokumen','unggah dokumen','kebutuhan dokumen','dokumen'],
        reply: 'Unggah dokumen pada form terkait (CRM/Manifest). Format disarankan: PDF/JPG/PNG sesuai ketentuan form.' },
      { triggers: ['error','gagal','masalah sistem','bug','tidak bisa'],
        reply: 'Mohon muat ulang halaman terlebih dulu. Jika masih bermasalah, hubungi Admin Esga atau Admin Eta melalui WhatsApp.' },
      { triggers: ['kontak','whatsapp','hubungi admin','admin'],
        reply: "Anda dapat menghubungi:<br>👉 <a href='https://wa.me/6281322181769' target='_blank' rel='noopener'>Admin Esga</a><br>👉 <a href='https://wa.me/6281221901810' target='_blank' rel='noopener'>Admin Eta</a>" }
    ];

    const FAQS = [
      { label: 'Cara isi Form CRM', ask: 'form crm' },
      { label: 'Cara isi Form Manifest', ask: 'form manifest' },
      { label: 'Jam Operasional', ask: 'jam operasional' },
      { label: 'Lupa Password', ask: 'lupa password' },
      { label: 'Hubungi Admin', ask: 'admin' },
      { label: 'Upload Dokumen', ask: 'upload dokumen' },
      { label: 'Daftar Akun', ask: 'register' },
      { label: 'Keluar (Logout)', ask: 'logout' }
    ];

    // Render FAQ chips
    FAQS.forEach(item => {
      const chip = document.createElement('button');
      chip.type = 'button';
      chip.className = 'chip';
      chip.textContent = item.label;
      chip.addEventListener('click', () => { markInteracted(); askFromFAQ(item.ask); });
      faqBar.appendChild(chip);
    });

    function askFromFAQ(text){
      chatInput.value = text;
      sendMsg();
    }

    sendBtn.addEventListener('click', sendMsg);
    chatInput.addEventListener('keydown', (e) => {
      if(e.key === 'Enter'){ e.preventDefault(); sendMsg(); }
    });

    function sendMsg(){
      const valRaw = chatInput.value;
      const val = normalize(valRaw);
      if(!val) return;
      appendMessage(escapeHtml(valRaw), 'me');
      chatInput.value='';

      // typing indicator
      const typing = document.createElement('div');
      typing.className = 'msg bot';
      typing.innerHTML = 'Sedang mengetik…';
      chatBody.appendChild(typing);
      chatBody.scrollTop = chatBody.scrollHeight;

      setTimeout(() => {
        typing.remove();
        const answer = findAnswer(val) || fallbackWhatsapp();
        appendMessage(answer, 'bot');
        playNotify();   // suara saat bot balas
        bumpUnread();   // badge kalau chat tertutup
      }, 450);
    }

    function findAnswer(msg){
      for(const item of QA){
        if(item.triggers.some(t => msg.includes(t))) return item.reply;
      }
      return null;
    }

    function fallbackWhatsapp(){
      return "Pertanyaan Anda belum tersedia di sistem. Silakan hubungi admin:<br>" +
             "👉 <a href='https://wa.me/6281322181769' target='_blank' rel='noopener'>Admin Esga</a><br>" +
             "👉 <a href='https://wa.me/6281221901810' target='_blank' rel='noopener'>Admin Eta</a>";
    }

    function appendMessage(html, sender){
      const msg = document.createElement('div');
      msg.className = 'msg ' + sender;
      msg.innerHTML = html;
      chatBody.appendChild(msg);
      chatBody.scrollTop = chatBody.scrollHeight;
    }

    function normalize(s){
      return s.toLowerCase()
              .replace(/[.,/#!$%^&*;:{}=~()\\[\\]\\-]/g,' ')
              .replace(/\\s+/g,' ')
              .trim();
    }
    function escapeHtml(str){
      const p = document.createElement('p');
      p.innerText = str;
      return p.innerHTML;
    }
  </script>
</body>
</html>
