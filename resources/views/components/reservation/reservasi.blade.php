<x-layouts.dashboard title="Reservation">
    @push('styles')
        <style>
            .res-tabs {
                display: flex;
                gap: 0;
                border: 1px solid var(--gym-border);
                width: fit-content;
                margin-bottom: 28px;
            }

            .res-tab {
                padding: 10px 28px;
                font-size: 0.78rem;
                font-weight: 600;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                cursor: pointer;
                background: transparent;
                color: var(--gym-gray);
                border: none;
                font-family: 'DM Sans', sans-serif;
                transition: background 0.2s, color 0.2s;
                position: relative;
            }

            .res-tab.active {
                background: var(--gym-red);
                color: #fff;
            }

            .res-tab:not(.active):hover {
                background: rgba(255, 255, 255, 0.04);
                color: var(--gym-white);
            }

            .res-panel {
                display: none;
            }

            .res-panel.active {
                display: block;
            }

            .res-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            @media (max-width: 900px) {
                .res-grid {
                    grid-template-columns: 1fr;
                }
            }

            .slot-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
                margin-top: 8px;
            }

            .slot-btn {
                padding: 10px 6px;
                background: #0d0d0d;
                border: 1px solid var(--gym-border);
                color: var(--gym-gray);
                font-size: 0.78rem;
                font-family: 'DM Sans', sans-serif;
                cursor: pointer;
                text-align: center;
                transition: all 0.18s;
                letter-spacing: 0.04em;
            }

            .slot-btn:hover:not(.taken) {
                border-color: var(--gym-red);
                color: var(--gym-white);
            }

            .slot-btn.selected {
                background: var(--gym-red);
                border-color: var(--gym-red);
                color: #fff;
                font-weight: 600;
            }

            .slot-btn.taken {
                opacity: 0.35;
                cursor: not-allowed;
                text-decoration: line-through;
            }

            /* ── Barcode panel ── */
            .barcode-wrap {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 20px;
                padding: 32px 24px;
            }

            .qr-box {
                width: 180px;
                height: 180px;
                background: #fff;
                padding: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                /* Corner decorations */
            }

            .qr-box::before,
            .qr-box::after {
                content: '';
                position: absolute;
                width: 18px;
                height: 18px;
                border-color: var(--gym-red);
                border-style: solid;
            }

            .qr-box::before {
                top: -4px;
                left: -4px;
                border-width: 3px 0 0 3px;
            }

            .qr-box::after {
                bottom: -4px;
                right: -4px;
                border-width: 0 3px 3px 0;
            }

            .qr-img {
                width: 156px;
                height: 156px;
                image-rendering: pixelated;
            }

            .barcode-id {
                font-family: 'Bebas Neue', sans-serif;
                font-size: 1.4rem;
                letter-spacing: 0.12em;
                color: var(--gym-white);
            }

            .barcode-meta {
                font-size: 0.78rem;
                color: var(--gym-gray);
                text-align: center;
                line-height: 1.6;
            }

            .status-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 4px 12px;
                font-size: 0.7rem;
                font-weight: 600;
                letter-spacing: 0.1em;
                text-transform: uppercase;
            }

            .status-badge.pending {
                background: rgba(234, 179, 8, 0.12);
                border: 1px solid rgba(234, 179, 8, 0.4);
                color: #facc15;
            }

            .status-badge.confirmed {
                background: rgba(34, 197, 94, 0.12);
                border: 1px solid rgba(34, 197, 94, 0.4);
                color: #4ade80;
            }

            .status-badge.done {
                background: rgba(99, 102, 241, 0.12);
                border: 1px solid rgba(99, 102, 241, 0.4);
                color: #a5b4fc;
            }

            .pulse {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: currentColor;
                animation: pulseAnim 1.4s ease-in-out infinite;
            }

            @keyframes pulseAnim {

                0%,
                100% {
                    opacity: 1;
                    transform: scale(1);
                }

                50% {
                    opacity: 0.4;
                    transform: scale(1.4);
                }
            }

            .history-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 14px 16px;
                border-bottom: 1px solid rgba(34, 34, 34, 0.7);
                gap: 12px;
            }

            .history-item:last-child {
                border-bottom: none;
            }

            .history-date {
                font-family: 'Bebas Neue', sans-serif;
                font-size: 1.1rem;
                letter-spacing: 0.06em;
                color: var(--gym-red);
                min-width: 54px;
                text-align: center;
            }

            .history-info {
                flex: 1;
            }

            .history-title {
                font-size: 0.85rem;
                font-weight: 600;
                color: var(--gym-white);
            }

            .history-sub {
                font-size: 0.75rem;
                color: var(--gym-gray);
                margin-top: 2px;
            }

            /* ── Chat panel ── */
            .chat-outer {
                display: grid;
                grid-template-columns: 220px 1fr;
                gap: 0;
                border: 1px solid var(--gym-border);
                height: 520px;
            }

            @media (max-width: 700px) {
                .chat-outer {
                    grid-template-columns: 1fr;
                    height: auto;
                }
            }

            .chat-sidebar {
                border-right: 1px solid var(--gym-border);
                background: var(--gym-dark);
                display: flex;
                flex-direction: column;
            }

            .chat-sidebar-title {
                padding: 14px 16px;
                font-size: 0.7rem;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: var(--gym-gray);
                border-bottom: 1px solid var(--gym-border);
            }

            .chat-contact {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 12px 16px;
                cursor: pointer;
                transition: background 0.2s;
                border-left: 2px solid transparent;
            }

            .chat-contact.active {
                background: rgba(255, 255, 255, 0.04);
                border-left-color: var(--gym-red);
            }

            .chat-contact:hover:not(.active) {
                background: rgba(255, 255, 255, 0.02);
            }

            .chat-avatar {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: var(--gym-border);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.75rem;
                font-weight: 700;
                color: var(--gym-white);
                flex-shrink: 0;
            }

            .chat-avatar.admin {
                background: rgba(232, 41, 42, 0.25);
                color: var(--gym-red);
            }

            .chat-contact-info .name {
                font-size: 0.82rem;
                font-weight: 600;
                color: var(--gym-white);
            }

            .chat-contact-info .role {
                font-size: 0.7rem;
                color: var(--gym-gray);
            }

            .chat-main {
                display: flex;
                flex-direction: column;
                background: var(--gym-card);
            }

            .chat-header {
                padding: 14px 20px;
                border-bottom: 1px solid var(--gym-border);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .chat-header-name {
                font-size: 0.9rem;
                font-weight: 600;
            }

            .online-dot {
                display: inline-block;
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: #4ade80;
                margin-left: 6px;
                vertical-align: middle;
            }

            .chat-messages {
                flex: 1;
                overflow-y: auto;
                padding: 20px;
                display: flex;
                flex-direction: column;
                gap: 14px;
                scrollbar-width: thin;
                scrollbar-color: var(--gym-border) transparent;
            }

            .msg {
                display: flex;
                gap: 10px;
                max-width: 80%;
            }

            .msg.me {
                align-self: flex-end;
                flex-direction: row-reverse;
            }

            .msg-bubble {
                padding: 10px 14px;
                font-size: 0.83rem;
                line-height: 1.5;
                border: 1px solid var(--gym-border);
                background: #0d0d0d;
                color: var(--gym-white);
            }

            .msg.me .msg-bubble {
                background: rgba(232, 41, 42, 0.15);
                border-color: rgba(232, 41, 42, 0.3);
                color: var(--gym-white);
            }

            .msg-time {
                font-size: 0.68rem;
                color: var(--gym-gray);
                margin-top: 4px;
                text-align: right;
            }

            .msg-avatar {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                background: var(--gym-border);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.68rem;
                font-weight: 700;
                flex-shrink: 0;
                align-self: flex-end;
            }

            .msg-avatar.admin-av {
                background: rgba(232, 41, 42, 0.25);
                color: var(--gym-red);
            }

            /* Quick reply chips */
            .quick-chips {
                padding: 8px 20px;
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
                border-top: 1px solid var(--gym-border);
            }

            .chip {
                padding: 5px 12px;
                font-size: 0.72rem;
                border: 1px solid var(--gym-border);
                color: var(--gym-gray);
                cursor: pointer;
                font-family: 'DM Sans', sans-serif;
                background: transparent;
                transition: all 0.18s;
                letter-spacing: 0.04em;
            }

            .chip:hover {
                border-color: var(--gym-red);
                color: var(--gym-white);
                background: rgba(232, 41, 42, 0.08);
            }

            .chat-input-row {
                display: flex;
                border-top: 1px solid var(--gym-border);
            }

            .chat-input {
                flex: 1;
                background: #0d0d0d;
                border: none;
                color: var(--gym-white);
                padding: 14px 18px;
                font-family: 'DM Sans', sans-serif;
                font-size: 0.88rem;
                outline: none;
            }

            .chat-input::placeholder {
                color: var(--gym-gray);
            }

            .chat-send {
                padding: 0 20px;
                background: var(--gym-red);
                border: none;
                color: #fff;
                cursor: pointer;
                font-family: 'DM Sans', sans-serif;
                font-size: 0.78rem;
                font-weight: 600;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                transition: background 0.2s;
            }

            .chat-send:hover {
                background: #c0392b;
            }

            .modal-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.75);
                z-index: 200;
                align-items: center;
                justify-content: center;
            }

            .modal-overlay.open {
                display: flex;
            }

            .modal-box {
                background: var(--gym-dark);
                border: 1px solid var(--gym-border);
                padding: 32px;
                max-width: 400px;
                width: 90%;
            }

            .modal-title {
                font-family: 'Bebas Neue', sans-serif;
                font-size: 1.6rem;
                letter-spacing: 0.06em;
                margin-bottom: 12px;
            }

            .modal-sub {
                font-size: 0.83rem;
                color: var(--gym-gray);
                margin-bottom: 24px;
                line-height: 1.6;
            }

            .modal-actions {
                display: flex;
                gap: 10px;
                justify-content: flex-end;
            }

            .btn-cancel {
                background: transparent;
                border: 1px solid var(--gym-border);
                color: var(--gym-gray);
                font-family: 'DM Sans', sans-serif;
                font-size: 0.78rem;
                padding: 9px 20px;
                cursor: pointer;
                letter-spacing: 0.06em;
                text-transform: uppercase;
                transition: all 0.2s;
            }

            .btn-cancel:hover {
                border-color: var(--gym-white);
                color: var(--gym-white);
            }
        </style>
    @endpush

    <div class="res-tabs">
        <button class="res-tab active" onclick="switchTab('book')">Buat Reservasi</button>
        <button class="res-tab" onclick="switchTab('ticket')">Tiket Saya</button>
        <button class="res-tab" onclick="switchTab('chat')">Chat Admin</button>
    </div>
    <div class="res-panel active" id="panel-book">
        <div class="res-grid">
            <div class="card">
                <div class="card-title">Detail Reservasi</div>
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-input" value="{{ Auth::user()->name }}" readonly
                        style="opacity:0.6;cursor:not-allowed;">
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Kunjungan</label>
                    <input type="date" class="form-input" id="resDate" min="{{ date('Y-m-d') }}"
                        value="{{ date('Y-m-d') }}" onchange="renderSlots()">
                </div>

                <div class="form-group">
                    <label class="form-label">Pilih Sesi</label>
                    <div class="slot-grid" id="slotGrid">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan (opsional)</label>
                    <textarea class="form-input" id="resNote" rows="3" placeholder="Contoh: saya ingin sesi squat rack..."></textarea>
                </div>
                <button class="btn-primary" onclick="openConfirm()">Konfirmasi Reservasi</button>
            </div>
            <div style="display:flex;flex-direction:column;gap:16px;">
                <div class="card">
                    <div class="card-title">Cara Reservasi</div>
                    <div style="display:flex;flex-direction:column;gap:14px;margin-top:4px;">
                        @foreach ([['01', 'Pilih tanggal & sesi yang tersedia'], ['02', 'Klik Konfirmasi Reservasi'], ['03', 'Tunjukkan QR Code di tab Tiket Saya'], ['04', 'Scan QR di pintu masuk gym']] as [$n, $t])
                            <div style="display:flex;align-items:center;gap:14px;">
                                <span
                                    style="font-family:'Bebas Neue',sans-serif;font-size:1.3rem;color:var(--gym-red);min-width:28px;">{{ $n }}</span>
                                <span style="font-size:0.83rem;color:var(--gym-light);">{{ $t }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card">
                    <div class="card-title">Info Kapasitas Hari Ini</div>
                    <div style="margin-top:4px;display:flex;flex-direction:column;gap:10px;" id="capacityInfo">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="res-panel" id="panel-ticket">
        <div class="res-grid">
            <div class="card">
                <div class="card-title">Tiket Aktif</div>
                <div class="barcode-wrap" id="barcodeWrap">
                    <div class="qr-box">
                        <canvas id="qrCanvas" class="qr-img" width="156" height="156"></canvas>
                    </div>
                    <div class="barcode-id" id="ticketCode">GYM-20250429-0831</div>
                    <div class="status-badge pending">
                        <span class="pulse"></span> Menunggu Scan
                    </div>
                    <div class="barcode-meta" id="ticketMeta">
                        Selasa, 29 April 2025<br>
                        Sesi: 08:00 – 10:00<br>
                        Member: <strong style="color:var(--gym-white)">{{ Auth::user()->name }}</strong>
                    </div>
                    <button class="btn-primary" onclick="refreshQR()" style="font-size:0.72rem;padding:8px 18px;">
                        Perbarui QR Code
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="card-title">Riwayat Reservasi</div>
                <div id="historyList">
                    @php
                        $history = [
                            ['APR', '28', 'Sesi Pagi', '06:00–08:00', 'confirmed'],
                            ['APR', '25', 'Sesi Siang', '10:00–12:00', 'done'],
                            ['APR', '21', 'Sesi Sore', '16:00–18:00', 'done'],
                            ['APR', '18', 'Sesi Malam', '18:00–20:00', 'done'],
                        ];
                    @endphp
                    @foreach ($history as [$mon, $day, $label, $time, $status])
                        <div class="history-item">
                            <div>
                                <div class="history-date">{{ $day }}</div>
                                <div
                                    style="font-size:0.65rem;color:var(--gym-gray);text-transform:uppercase;letter-spacing:.06em">
                                    {{ $mon }}</div>
                            </div>
                            <div class="history-info">
                                <div class="history-title">{{ $label }}</div>
                                <div class="history-sub">{{ $time }}</div>
                            </div>
                            <span class="status-badge {{ $status }}">
                                {{ $status === 'confirmed' ? 'Terkonfirmasi' : 'Selesai' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="res-panel" id="panel-chat">
        <div class="chat-outer">
            <div class="chat-sidebar">
                <div class="chat-sidebar-title">Kontak</div>
                <div class="chat-contact active" onclick="selectContact(this,'Admin Gym')">
                    <div class="chat-avatar admin">AG</div>
                    <div class="chat-contact-info">
                        <div class="name">Admin Gym</div>
                        <div class="role">Receptionist</div>
                    </div>
                </div>
                <div class="chat-contact" onclick="selectContact(this,'Trainer Budi')">
                    <div class="chat-avatar" style="background:rgba(99,102,241,.25);color:#a5b4fc">TB</div>
                    <div class="chat-contact-info">
                        <div class="name">Trainer Budi</div>
                        <div class="role">Personal Trainer</div>
                    </div>
                </div>
                <div class="chat-contact" onclick="selectContact(this,'CS Support')">
                    <div class="chat-avatar" style="background:rgba(34,197,94,.2);color:#4ade80">CS</div>
                    <div class="chat-contact-info">
                        <div class="name">CS Support</div>
                        <div class="role">Customer Service</div>
                    </div>
                </div>
            </div>
            <div class="chat-main">
                <div class="chat-header">
                    <span class="chat-header-name" id="chatContactName">
                        Admin Gym <span class="online-dot"></span>
                    </span>
                    <span style="font-size:0.72rem;color:var(--gym-gray)">Online</span>
                </div>

                <div class="chat-messages" id="chatMessages">
                    <div class="msg">
                        <div class="msg-avatar admin-av">AG</div>
                        <div>
                            <div class="msg-bubble">Halo kak! Ada yang bisa dibantu terkait reservasi atau info gym
                                hari ini? 💪</div>
                            <div class="msg-time">09:01</div>
                        </div>
                    </div>
                    <div class="msg me">
                        <div class="msg-avatar" style="background:var(--gym-red);color:#fff">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                        <div>
                            <div class="msg-bubble">Halo min, mau tanya slot sesi sore masih ada ga?</div>
                            <div class="msg-time">09:03</div>
                        </div>
                    </div>
                    <div class="msg">
                        <div class="msg-avatar admin-av">AG</div>
                        <div>
                            <div class="msg-bubble">Masih ada kak! Sesi 16:00–18:00 tinggal 4 slot. Mau dibantu
                                reservasi sekarang?</div>
                            <div class="msg-time">09:04</div>
                        </div>
                    </div>
                </div>
                <div class="quick-chips">
                    <button class="chip" onclick="sendChip(this)">Slot tersedia hari ini?</button>
                    <button class="chip" onclick="sendChip(this)">Konfirmasi reservasi saya</button>
                    <button class="chip" onclick="sendChip(this)">Jadwal trainer?</button>
                    <button class="chip" onclick="sendChip(this)">Perpanjang membership</button>
                </div>

                <div class="chat-input-row">
                    <input class="chat-input" id="chatInput" type="text" placeholder="Tulis pesan..."
                        onkeydown="if(event.key==='Enter')sendMsg()">
                    <button class="chat-send" onclick="sendMsg()">Kirim</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-overlay" id="confirmModal">
        <div class="modal-box">
            <div class="modal-title">Konfirmasi Reservasi</div>
            <div class="modal-sub" id="confirmText">
                Kamu akan mereservasi sesi <strong id="cfDate">—</strong>,
                pukul <strong id="cfSlot">—</strong>.<br>
                Pastikan kamu hadir tepat waktu. Reservasi hangus jika tidak scan dalam 15 menit pertama.
            </div>
            <div class="modal-actions">
                <button class="btn-cancel" onclick="closeConfirm()">Batal</button>
                <button class="btn-primary" onclick="doReserve()">Ya, Reservasi!</button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
        <script>
            function switchTab(t) {
                document.querySelectorAll('.res-panel').forEach(p => p.classList.remove('active'));
                document.querySelectorAll('.res-tab').forEach(b => b.classList.remove('active'));
                document.getElementById('panel-' + t).classList.add('active');
                event.currentTarget.classList.add('active');
                if (t === 'ticket') drawQR(document.getElementById('ticketCode').textContent.trim());
            }
            const SESSIONS = [{
                    label: '06:00',
                    end: '08:00',
                    taken: false
                },
                {
                    label: '08:00',
                    end: '10:00',
                    taken: false
                },
                {
                    label: '10:00',
                    end: '12:00',
                    taken: true
                },
                {
                    label: '12:00',
                    end: '14:00',
                    taken: false
                },
                {
                    label: '14:00',
                    end: '16:00',
                    taken: true
                },
                {
                    label: '16:00',
                    end: '18:00',
                    taken: false
                },
                {
                    label: '18:00',
                    end: '20:00',
                    taken: false
                },
                {
                    label: '20:00',
                    end: '22:00',
                    taken: false
                },
            ];
            let selectedSlot = null;

            function renderSlots() {
                const grid = document.getElementById('slotGrid');
                grid.innerHTML = '';
                SESSIONS.forEach((s, i) => {
                    const btn = document.createElement('button');
                    btn.className = 'slot-btn' + (s.taken ? ' taken' : '') + (selectedSlot === i ? ' selected' : '');
                    btn.textContent = s.label;
                    if (!s.taken) btn.onclick = () => selectSlot(i);
                    grid.appendChild(btn);
                });
                renderCapacity();
            }

            function selectSlot(i) {
                selectedSlot = i;
                renderSlots();
            }

            function renderCapacity() {
                const el = document.getElementById('capacityInfo');
                const available = SESSIONS.filter(s => !s.taken).length;
                const total = SESSIONS.length;
                const pct = Math.round((SESSIONS.filter(s => s.taken).length / total) * 100);
                el.innerHTML = `
        <div style="display:flex;justify-content:space-between;font-size:.8rem;">
            <span style="color:var(--gym-gray)">Slot Tersedia</span>
            <span style="color:var(--gym-white);font-weight:600">${available} / ${total}</span>
        </div>
        <div style="height:6px;background:var(--gym-border);">
            <div style="height:100%;width:${pct}%;background:var(--gym-red);transition:width .4s;"></div>
        </div>
        <div style="font-size:.72rem;color:var(--gym-gray);">
            ${pct}% kapasitas terisi — ${pct < 50 ? ' Sepi' : pct < 80 ? ' Ramai' : ' Penuh'}
        </div>
    `;
            }

            function openConfirm() {
                if (selectedSlot === null) {
                    alert('Pilih sesi terlebih dahulu!');
                    return;
                }
                const s = SESSIONS[selectedSlot];
                const d = document.getElementById('resDate').value;
                document.getElementById('cfDate').textContent = d;
                document.getElementById('cfSlot').textContent = `${s.label} – ${s.end}`;
                document.getElementById('confirmModal').classList.add('open');
            }

            function closeConfirm() {
                document.getElementById('confirmModal').classList.remove('open');
            }

            function doReserve() {
                closeConfirm();
                const code = 'GYM-' + new Date().toISOString().slice(0, 10).replace(/-/g, '') + '-' + Math.floor(1000 + Math
                    .random() * 9000);
                document.getElementById('ticketCode').textContent = code;
                document.querySelectorAll('.res-panel').forEach(p => p.classList.remove('active'));
                document.querySelectorAll('.res-tab').forEach(b => b.classList.remove('active'));
                document.getElementById('panel-ticket').classList.add('active');
                document.querySelectorAll('.res-tab')[1].classList.add('active');
                drawQR(code);
                const s = SESSIONS[selectedSlot];
                const d = document.getElementById('resDate').value;
                document.getElementById('ticketMeta').innerHTML =
                    `${d}<br>Sesi: ${s.label} – ${s.end}<br>Member: <strong style="color:var(--gym-white)">{{ Auth::user()->name }}</strong>`;
            }

            function drawQR(text) {
                const canvas = document.getElementById('qrCanvas');
                if (!canvas) return;
                new QRious({
                    element: canvas,
                    value: text,
                    size: 156,
                    level: 'M',
                    background: '#ffffff',
                    foreground: '#000000',
                    padding: 6,
                });
            }

            function refreshQR() {
                const code = document.getElementById('ticketCode').textContent.trim();
                drawQR(code);
            }
            const adminReplies = [
                'Tentu kak, kami siap membantu! Ada hal lain yang ingin ditanyakan?',
                'Reservasi kamu sudah tercatat ya kak 😊',
                'Silakan datang 10 menit sebelum sesi dimulai untuk scan QR.',
                'Jika ada kendala, jangan ragu menghubungi kami kembali!',
                'Kapasitas hari ini masih ada, langsung bisa datang ya kak.',
            ];
            let replyIndex = 0;

            function sendMsg() {
                const input = document.getElementById('chatInput');
                const text = input.value.trim();
                if (!text) return;
                appendMsg(text, 'me');
                input.value = '';
                setTimeout(() => appendMsg(adminReplies[replyIndex++ % adminReplies.length], 'them'), 800);
            }

            function sendChip(btn) {
                appendMsg(btn.textContent, 'me');
                setTimeout(() => appendMsg(adminReplies[replyIndex++ % adminReplies.length], 'them'), 800);
            }

            function appendMsg(text, who) {
                const wrap = document.getElementById('chatMessages');
                const initials = who === 'me' ?
                    '{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}' :
                    'AG';
                const avClass = who === 'me' ?
                    'style="background:var(--gym-red);color:#fff"' :
                    'class="admin-av"';
                const now = new Date();
                const time = `${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}`;
                wrap.innerHTML += `
        <div class="msg ${who === 'me' ? 'me' : ''}">
            <div class="msg-avatar ${avClass}">${initials}</div>
            <div>
                <div class="msg-bubble">${text}</div>
                <div class="msg-time">${time}</div>
            </div>
        </div>`;
                wrap.scrollTop = wrap.scrollHeight;
            }

            function selectContact(el, name) {
                document.querySelectorAll('.chat-contact').forEach(c => c.classList.remove('active'));
                el.classList.add('active');
                document.getElementById('chatContactName').innerHTML = name + ' <span class="online-dot"></span>';
            }
            document.addEventListener('DOMContentLoaded', () => {
                renderSlots();
                drawQR(document.getElementById('ticketCode').textContent.trim());
            });
        </script>
    @endpush
</x-layouts.dashboard>