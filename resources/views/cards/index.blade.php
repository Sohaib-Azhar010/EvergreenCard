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

        /* Custom Checkbox Styles */
        .custom-checkbox {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 1px solid #7b7b7b;
            background-color: white;
            margin-left: 15px;
            position: relative;
            border-radius: 0;
            cursor: pointer;
        }

        .custom-checkbox::after {
            content: '';
            position: absolute;
            display: none;
            left: 4px;
            top: 1px;
            width: 4px;
            height: 8px;
            border: solid #000;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        input[type="checkbox"]:checked + .custom-checkbox::after {
            display: block;
        }

        input[type="checkbox"]:checked + .custom-checkbox {
            background-color: white;
            border-color: #000;
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
                                        <th>Header</th>
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
                                        <td>{{ $card->header ?? 'N/A' }}</td>
                                        <td>{{ $card->company_number }}</td>
                                        <td>{{ $card->membership_number }}</td>
                                        <td>{{ $card->request_number }}</td>
                                        <td>{{ $card->valid_until->format('Y-m-d') }}</td>
                                        <td class="arabic-text">{{ $card->created_by }}</td>
                                        <td>{{ $card->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                onclick="downloadCard({{ $card->id }}, '{{ $card->header ?? '' }}', '{{ $card->company_number }}', '{{ $card->membership_number }}', '{{ $card->request_number }}', '{{ $card->valid_until->format('Y-m-d') }}', '{{ $card->created_by }}')">
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
        async function downloadCard(id, header, companyNumber, membershipNumber, requestNumber, validUntil, createdBy) {
            const cardHtml = `
                <div id="card-${id}" style="
                    width: 540px;
                    height: 340px;
                    border: 2px solid #000;
                    border-radius: 15px;
                    background: #fff;
                    font-family: 'Arial', 'Tahoma', sans-serif;
                    direction: rtl;
                    position: relative;
                    box-sizing: border-box;
                    overflow: hidden;
                ">
                    <!-- Header -->
                    ${header ? `
                    <div style="
                        position: absolute;
                        top: 25px;
                        right: 50px;
                        font-size: 16px;
                        font-weight: bold;
                        color: #333;
                    ">
                        ${header}
                    </div>
                    ` : ''}
                    
        
                    <!-- QR Code -->
                    <div style="
                        position: absolute;
                        top: 80px;
                        left: 10px;
                        width: 190px;
                        height: 190px;
                        text-align: center;
                    ">
                        <img src="{{ asset('images/qr.png') }}" style="width: 130px; height: 130px;" alt="QR Code">
                    </div>
        
                    <!-- Numbers (Center) -->
                    <div style="
                        position: absolute;
                        top: 75px;
                        right: 160px;
                        text-align: right;
                        font-size: 17px;
                        line-height: 2;
                    ">
                        <div>${companyNumber}</div>
                        <div>${membershipNumber}</div>
                        <div>${requestNumber}</div>
                        <div>${validUntil}</div>
                        <div style="font-size: 18px;font-weight: 700;">${createdBy}</div>
                    </div>
        
                    <!-- Labels + Checkboxes (Right Side) -->
                    <div style="
                        position: absolute;
                        top: 75px;
                        right: 20px;
                        text-align: right;
                        font-size: 16px;
                        font-weight: bold;
                        line-height: 2;
                        color: #555;
                        font-family: 'Segoe UI', 'Tahoma', 'Arial', 'Noto Sans Arabic', sans-serif;
                    ">
                        <div><label style="display: flex; align-items: center; cursor: pointer;"><input type="checkbox" style="display: none;"><span class="custom-checkbox"></span>رقم المنشأة</label></div>
                        <div><label style="display: flex; align-items: center; cursor: pointer;"><input type="checkbox" style="display: none;"><span class="custom-checkbox"></span>رقم العضوية</label></div>
                        <div><label style="display: flex; align-items: center; cursor: pointer;"><input type="checkbox" style="display: none;"><span class="custom-checkbox"></span>رقم الطلب</label></div>
                        <div><label style="display: flex; align-items: center; cursor: pointer;"><input type="checkbox" style="display: none;"><span class="custom-checkbox"></span>ساري حتى</label></div>
                        <div style="margin-top: 10px;"><label style="display: flex; align-items: center; cursor: pointer;"><input type="checkbox" style="display: none;"><span class="custom-checkbox"></span>تم بواسطة</label></div>
                    </div>
        
                    
        
                    <!-- Footer Disclaimer -->
                    <div style="
                        position: absolute;
                        bottom: 15px;
                        left: 20px;
                        right: 20px;
                        font-size: 16px;
                        font-weight: bold;
                        color: #000;
                        background: #ABCDEF;
                        border-radius: 6px;
                        padding: 6px;
                        line-height: 1;
                        text-align: justify;
                        font-family: 'Segoe UI', 'Tahoma', 'Arial', 'Noto Sans Arabic', sans-serif;
                    ">
                        تم إصدار هذا الختم بناءً على طلب المشترك، وتخلي الغرفة التجارية بينبع التي تم تقديم الطلب من خلالها مسؤوليتها عن محتواها.
                        للتحقق من الختم امسح الـ QR Code أو من خلال الرابط.
                    </div>
                </div>
            `;
        
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = cardHtml;
            tempDiv.style.position = 'absolute';
            tempDiv.style.left = '-9999px';
            document.body.appendChild(tempDiv);
        
            const cardElement = tempDiv.querySelector(`#card-${id}`);
        
            try {
                const canvas = await html2canvas(cardElement, { scale: 2, useCORS: true });
                const { jsPDF } = window.jspdf;
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('landscape', 'mm', 'a4');
        
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();
                const imgWidth = canvas.width;
                const imgHeight = canvas.height;
                const ratio = Math.min(pdfWidth / imgWidth, pdfHeight / imgHeight);
                const finalWidth = imgWidth * ratio;
                const finalHeight = imgHeight * ratio;
        
                const x = (pdfWidth - finalWidth) / 2;
                const y = (pdfHeight - finalHeight) / 2;
        
                pdf.addImage(imgData, 'PNG', x, y, finalWidth, finalHeight);
                pdf.save(`card_${companyNumber}_${requestNumber}.pdf`);
            } catch (error) {
                console.error('Error generating PDF:', error);
                alert('Error generating PDF. Please try again.');
            } finally {
                document.body.removeChild(tempDiv);
            }
        }
        </script>
        
        
        

</body>

</html>