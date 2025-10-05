<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EvergreenCard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .arabic-text {
            font-family: 'Arial', 'Tahoma', sans-serif;
            font-size: 16px;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-nav ms-auto">
                <a href="{{ route('cards.index') }}" class="btn btn-info me-3">Show Cards</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0 arabic-text">إنشاء بطاقة جديدة</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('cards.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="header" class="form-label">Header</label>
                                    <input type="text" class="form-control" id="header" name="header" placeholder="Enter header text">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="company_number" class="form-label arabic-text">رقم المنشأة</label>
                                    <input type="text" class="form-control" id="company_number" name="company_number">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="membership_number" class="form-label arabic-text">رقم العضوية</label>
                                    <input type="text" class="form-control" id="membership_number" name="membership_number">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="request_number" class="form-label arabic-text">رقم الطلب</label>
                                    <input type="text" class="form-control" id="request_number" name="request_number">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="valid_until" class="form-label arabic-text">ساري حتي</label>
                                    <input type="date" class="form-control" id="valid_until" name="valid_until">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="created_by" class="form-label arabic-text">تم بواسطة</label>
                                    <input type="text" class="form-control" id="created_by" name="created_by">
                                </div>
                            </div>
                            
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary me-md-2">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create Card</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</body>
</html>
