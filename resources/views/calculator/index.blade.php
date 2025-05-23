@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Kalkulator Persentase & Margin Error</div>

                <div class="card-body">
                    <form id="calculatorForm">
                        <div class="mb-3">
                            <label for="value" class="form-label">Nilai</label>
                            <input type="number" class="form-control" id="value" name="value" step="any" required min="0">
                        </div>

                        <div class="mb-3">
                            <label for="total" class="form-label">Total</label>
                            <input type="number" class="form-control" id="total" name="total" step="any" required min="0">
                        </div>

                        <div class="mb-3">
                            <label for="sample_size" class="form-label">Ukuran Sampel</label>
                            <input type="number" class="form-control" id="sample_size" name="sample_size" required min="1">
                        </div>

                        <button type="submit" class="btn btn-primary">Hitung</button>
                    </form>

                    <div id="result" class="mt-4" style="display: none;">
                        <h4>Hasil Perhitungan:</h4>
                        <div class="alert alert-info">
                            <p>Persentase: <span id="percentage"></span>%</p>
                            <p>Margin Error: <span id="marginError"></span>%</p>
                            <p>Interval Kepercayaan: <span id="confidenceInterval"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('calculatorForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    try {
        const response = await fetch('{{ route("calculator.calculate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            document.getElementById('percentage').textContent = result.data.percentage;
            document.getElementById('marginError').textContent = result.data.margin_error;
            document.getElementById('confidenceInterval').textContent = 
                `${result.data.confidence_interval.lower}% - ${result.data.confidence_interval.upper}%`;
            document.getElementById('result').style.display = 'block';
        } else {
            alert(result.message);
        }
    } catch (error) {
        alert('Terjadi kesalahan saat menghitung');
    }
});
</script>
@endpush
@endsection 