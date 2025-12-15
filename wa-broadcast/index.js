// === Import library yang dibutuhkan ===
const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcodeTerminal = require('qrcode-terminal');
const QRCode = require('qrcode');
const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');

// === Inisialisasi aplikasi Express ===
const app = express();
app.use(cors());
app.use(bodyParser.json());

let qrCodeData = null; // variabel untuk simpan QR code

// === Inisialisasi WhatsApp Web Client ===
const client = new Client({
    authStrategy: new LocalAuth(), // Simpan session login
    puppeteer: {
        headless: true,
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    },
    webVersionCache: {
    type: "remote",
    remotePath: "https://raw.githubusercontent.com/wppconnect-team/wa-version/main/html/2.2412.51.html"
}

});

// === Fungsi format nomor otomatis ===
const formatNumber = (number) => {
    let cleaned = number.toString().replace(/\D/g, ''); // hapus non-angka
    if (cleaned.startsWith('0')) {
        cleaned = '62' + cleaned.substring(1);
    }
    return `${cleaned}@c.us`;
};

// === Event saat QR code muncul di terminal ===
client.on('qr', async (qr) => {
    console.log('📲 Scan QR ini di WhatsApp:');
    qrcodeTerminal.generate(qr, { small: true }); // tampil di terminal
    qrCodeData = await QRCode.toDataURL(qr);
});

// === Event saat WhatsApp siap digunakan ===
// === Event saat WhatsApp siap digunakan ===
client.on('ready', async () => {
    console.log('✅ WhatsApp Web siap digunakan!');
    qrCodeData = null; // hapus QR code karena sudah login

    // --- Tes kirim pesan otomatis ---
    const testNumber = "628125628425@c.us"; // ganti dengan nomor WA aktif
    try {
        await client.sendMessage(testNumber, "Halo ini pesan test langsung dari Node.js ✅");
        console.log(`📩 Pesan test terkirim ke ${testNumber}`);
    } catch (err) {
        console.error("⚠️ Gagal kirim pesan test:", err.message);
    }
});

// === Error handling tambahan ===
client.on('auth_failure', (msg) => {
    console.error('❌ Auth gagal:', msg);
});

client.on('disconnected', (reason) => {
    console.log('❌ WhatsApp terputus, alasan:', reason);
});

// === Endpoint untuk ambil QR code di browser / Laravel ===
app.get('/qr', (req, res) => {
    if (qrCodeData) {
        res.json({ status: 'QR', image: qrCodeData });
    } else {
        res.json({ status: 'READY', message: 'WhatsApp sudah siap!' });
    }
});

// === Endpoint kirim pesan dari Laravel ===
app.post('/send-message', async (req, res) => {
    const { numbers, message } = req.body;

    if (!numbers || !Array.isArray(numbers)) {
        return res.status(400).json({ status: 'error', message: 'Numbers harus array' });
    }

    let results = [];

    for (let number of numbers) {
        try {
            let formattedNumber = number;

            // pastikan format ke 62xxxxxxxxxx
            if (!formattedNumber.startsWith('62')) {
                formattedNumber = '62' + formattedNumber.replace(/^0+/, '');
            }

            // format untuk whatsapp-web.js
            const chatId = `${formattedNumber}@c.us`;

            // langsung kirim tanpa getChat
            await client.sendMessage(chatId, message);

            console.log(`✅ Pesan terkirim ke: ${chatId}`);
            results.push({ number: chatId, status: 'sent' });

        } catch (error) {
            console.error(`⚠️ Error kirim ke ${number}:`, error.message);
            results.push({ number, status: 'failed', error: error.message });
        }
    }

    res.json({ status: 'success', results });
});


// === Endpoint tes koneksi ===
app.get('/', (req, res) => {
    res.send('🚀 Server WhatsApp API berjalan!');
});

// === Jalankan server Node.js ===
app.listen(3000, '0.0.0.0', () => {
    console.log('🚀 Server WA berjalan di http://localhost:3000');
});

// === Mulai WhatsApp Web ===
client.initialize();
