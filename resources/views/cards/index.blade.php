<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cards - EvergreenCard</title>
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
                <a href="{{ route('cards.create') }}" class="btn btn-success me-3">Create Card</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 arabic-text">البطاقات المُنشأة</h4>
                        <a href="{{ route('cards.create') }}" class="btn btn-primary">Create New Card</a>
                    </div>
                    <div class="card-body">
                        @if($cards->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="arabic-text">رقم المنشأة</th>
                                            <th class="arabic-text">رقم العضوية</th>
                                            <th class="arabic-text">رقم الطلب</th>
                                            <th class="arabic-text">ساري حتي</th>
                                            <th class="arabic-text">تم بواسطة</th>
                                            <th class="arabic-text">تاريخ الإنشاء</th>
                                            <th class="arabic-text">تحميل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cards as $card)
                                            <tr>
                                                <td>{{ $card->company_number }}</td>
                                                <td>{{ $card->membership_number }}</td>
                                                <td>{{ $card->request_number }}</td>
                                                <td>{{ $card->valid_until->format('Y-m-d') }}</td>
                                                <td class="arabic-text">{{ $card->created_by }}</td>
                                                <td>{{ $card->created_at->format('Y-m-d H:i') }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" onclick="downloadCard({{ $card->id }}, '{{ $card->company_number }}', '{{ $card->membership_number }}', '{{ $card->request_number }}', '{{ $card->valid_until->format('Y-m-d') }}', '{{ $card->created_by }}')">
                                                        <i class="fas fa-download"></i> تحميل
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <h5 class="arabic-text">لا توجد بطاقات مُنشأة</h5>
                                    <p class="arabic-text">ابدأ بإنشاء بطاقة جديدة</p>
                                    <a href="{{ route('cards.create') }}" class="btn btn-primary">Create First Card</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script>
        async function downloadCard(id, companyNumber, membershipNumber, requestNumber, validUntil, createdBy) {
            // Create HTML card element
            const cardHtml = `
                <div id="card-${id}" style="
                    width: 400px;
                    height: 250px;
                    border: 2px solid #000;
                    border-radius: 10px;
                    background: white;
                    padding: 20px;
                    font-family: 'Arial', 'Tahoma', sans-serif;
                    direction: rtl;
                    text-align: right;
                    position: relative;
                    margin: 20px auto;
                ">
                    <!-- Company Name -->
                    <div style="text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 20px;">
                        شركة إيفر غرين إنتيلجنت
                    </div>
                    
                    <!-- Card Content -->
                    <div style="display: flex; height: 150px;">
                        <!-- QR Code Area -->
                        <div style="width: 120px; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('images/qr.png') }}" style="width: 100px; height: 100px;" alt="QR Code">
                        </div>
                        
                        <!-- Data Area -->
                        <div style="flex: 1; padding-right: 20px;">
                            <div style="margin-bottom: 8px;">
                                <span style="font-weight: bold;">رقم المنشأة:</span> ${companyNumber}
                            </div>
                            <div style="margin-bottom: 8px;">
                                <span style="font-weight: bold;">رقم العضوية:</span> ${membershipNumber}
                            </div>
                            <div style="margin-bottom: 8px;">
                                <span style="font-weight: bold;">رقم الطلب:</span> ${requestNumber}
                            </div>
                            <div style="margin-bottom: 8px;">
                                <span style="font-weight: bold;">ساري حتى:</span> ${validUntil}
                            </div>
                            <div style="margin-top: 15px;">
                                <span style="font-weight: bold;">إيفر غرين إنتيلجنت</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Disclaimer -->
                    <div style="
                        position: absolute;
                        bottom: 10px;
                        left: 10px;
                        right: 10px;
                        font-size: 8px;
                        color: #666;
                        text-align: center;
                        line-height: 1.2;
                    ">
                        تم إصدار هذا الختم بناءً على طلب المشترك، وتخلي الغرفة التجارية بينبع التي تم تقديم الطلب من خلالها مسؤوليتها عن محتواها. للتحقق من الختم امسح الـ QR Code أو من خلال الرابط.
                    </div>
                </div>
            `;
            
            // Create temporary container
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = cardHtml;
            tempDiv.style.position = 'absolute';
            tempDiv.style.left = '-9999px';
            tempDiv.style.top = '0';
            document.body.appendChild(tempDiv);
            
            const cardElement = tempDiv.querySelector(`#card-${id}`);
            
            try {
                // Convert HTML to canvas
                const canvas = await html2canvas(cardElement, {
                    scale: 2,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#ffffff'
                });
                
                // Create PDF
                const { jsPDF } = window.jspdf;
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('landscape', 'mm', 'a4');
                
                // Calculate dimensions to fit the card on A4
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();
                const imgWidth = canvas.width;
                const imgHeight = canvas.height;
                const ratio = Math.min(pdfWidth / imgWidth, pdfHeight / imgHeight);
                const finalWidth = imgWidth * ratio;
                const finalHeight = imgHeight * ratio;
                
                // Center the image on the page
                const x = (pdfWidth - finalWidth) / 2;
                const y = (pdfHeight - finalHeight) / 2;
                
                pdf.addImage(imgData, 'PNG', x, y, finalWidth, finalHeight);
                pdf.save(`card_${companyNumber}_${requestNumber}.pdf`);
                
            } catch (error) {
                console.error('Error generating PDF:', error);
                alert('Error generating PDF. Please try again.');
            } finally {
                // Clean up
                document.body.removeChild(tempDiv);
            }
        }
    </script>
</body>
</html>
