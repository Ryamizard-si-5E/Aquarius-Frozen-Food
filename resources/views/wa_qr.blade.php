@section('content')
<div class="container">
    <h3>QR Code WhatsApp</h3>

    @if ($data['status'] === 'QR')
        <p>Silakan scan QR Code berikut di WhatsApp Web Anda:</p>
        <img src="{{ $data['image'] }}" alt="QR Code" style="width:300px;">
    @elseif ($data['status'] === 'READY')
        <p>✅ WhatsApp sudah siap digunakan!</p>
    @else
        <p>Gagal memuat QR Code</p>
    @endif

    <hr>

    <h3>Kirim Pesan WhatsApp</h3>
    <form method="POST" action="{{ route('wa.send') }}">
        @csrf
        <div class="mb-3">
            <label>Nomor WhatsApp (pisahkan dengan koma)</label>
            <input type="text" name="numbers[]" class="form-control" placeholder="6281234567890" required>
        </div>
        <div class="mb-3">
            <label>Pesan</label>
            <textarea name="message" class="form-control" required></textarea>
        </div>
        <button class="btn btn-primary">Kirim</button>
    </form>
</div>
@endsection
