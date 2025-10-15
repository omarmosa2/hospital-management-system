<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أضبارة المريض - {{ $patient->user->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #3B82F6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .hospital-name {
            font-size: 24px;
            font-weight: bold;
            color: #1E40AF;
            margin-bottom: 10px;
        }
        
        .patient-title {
            font-size: 20px;
            color: #374151;
            margin-bottom: 5px;
        }
        
        .patient-subtitle {
            font-size: 14px;
            color: #6B7280;
        }
        
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #1F2937;
            border-bottom: 2px solid #E5E7EB;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-item {
            display: table-cell;
            padding: 8px 0;
            border-bottom: 1px solid #F3F4F6;
            width: 50%;
        }
        
        .info-label {
            font-weight: bold;
            color: #374151;
        }
        
        .info-value {
            color: #6B7280;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .table th,
        .table td {
            border: 1px solid #D1D5DB;
            padding: 8px 12px;
            text-align: right;
        }
        
        .table th {
            background-color: #F9FAFB;
            font-weight: bold;
            color: #374151;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-scheduled {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .status-confirmed {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
        
        .status-completed {
            background-color: #D1FAE5;
            color: #065F46;
        }
        
        .status-cancelled {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #6B7280;
            border-top: 1px solid #E5E7EB;
            padding-top: 20px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="hospital-name">مستشفى الإدارة الطبية</div>
        <div class="patient-title">أضبارة المريض</div>
        <div class="patient-subtitle">{{ $patient->user->name }} - رقم الملف: {{ $patient->medical_record_number }}</div>
    </div>

    <!-- Patient Information -->
    <div class="section">
        <div class="section-title">المعلومات الشخصية</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">الاسم الكامل:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->user->name }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">البريد الإلكتروني:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->user->email }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">رقم الهاتف:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->phone ?? 'غير محدد' }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">العنوان:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->address ?? 'غير محدد' }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">العمر:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->age ?? 'غير محدد' }} سنة</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">الجنس:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->gender == 'male' ? 'ذكر' : 'أنثى' }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">تاريخ الميلاد:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->date_of_birth ? $patient->date_of_birth->format('d/m/Y') : 'غير محدد' }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">الحالة الاجتماعية:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->marital_status ?? 'غير محدد' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Information -->
    <div class="section">
        <div class="section-title">المعلومات الطبية</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">فصيلة الدم:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->blood_type ?? 'غير محدد' }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">الوزن:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->weight ?? 'غير محدد' }} كغ</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">الطول:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->height ?? 'غير محدد' }} سم</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">الحساسية:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->allergies ?? 'لا توجد' }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">الأمراض المزمنة:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->chronic_conditions ?? 'لا توجد' }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">الأدوية الحالية:</span>
                </div>
                <div class="info-item">
                    <span class="info-value">{{ $patient->current_medications ?? 'لا توجد' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments History -->
    <div class="section">
        <div class="section-title">تاريخ المواعيد</div>
        @if($patient->appointments->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>الطبيب</th>
                        <th>العيادة</th>
                        <th>السبب</th>
                        <th>الحالة</th>
                        <th>الرسوم</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patient->appointments as $appointment)
                        <tr>
                            <td>
                                {{ $appointment->appointment_date->format('d/m/Y') }}<br>
                                <small>{{ $appointment->appointment_time }}</small>
                            </td>
                            <td>{{ $appointment->doctor->user->name ?? 'غير محدد' }}</td>
                            <td>{{ $appointment->clinic->name ?? 'غير محدد' }}</td>
                            <td>{{ $appointment->reason ?? 'غير محدد' }}</td>
                            <td>
                                <span class="status-badge status-{{ $appointment->status }}">
                                    @if($appointment->status == 'scheduled') مجدول
                                    @elseif($appointment->status == 'confirmed') مؤكد
                                    @elseif($appointment->status == 'completed') مكتمل
                                    @else ملغي
                                    @endif
                                </span>
                            </td>
                            <td>${{ number_format($appointment->fee ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #6B7280; padding: 20px;">لا توجد مواعيد مسجلة</p>
        @endif
    </div>

    <!-- Medical Records -->
    <div class="section page-break">
        <div class="section-title">السجلات الطبية</div>
        @if($patient->medicalRecords->count() > 0)
            @foreach($patient->medicalRecords as $record)
                <div style="border: 1px solid #D1D5DB; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                        <h4 style="margin: 0; font-size: 16px; color: #374151;">{{ $record->title }}</h4>
                        <span style="font-size: 12px; color: #6B7280;">{{ $record->created_at->format('d/m/Y') }}</span>
                    </div>
                    <p style="margin: 0 0 10px 0; color: #6B7280; font-size: 14px;">{{ $record->description }}</p>
                    @if($record->diagnosis)
                        <div>
                            <span style="font-weight: bold; color: #374151; font-size: 14px;">التشخيص:</span>
                            <span style="color: #6B7280; font-size: 14px;">{{ $record->diagnosis }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <p style="text-align: center; color: #6B7280; padding: 20px;">لا توجد سجلات طبية</p>
        @endif
    </div>

    <!-- Prescriptions -->
    <div class="section">
        <div class="section-title">الوصفات الطبية</div>
        @if($patient->prescriptions->count() > 0)
            @foreach($patient->prescriptions as $prescription)
                <div style="border: 1px solid #D1D5DB; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                        <h4 style="margin: 0; font-size: 16px; color: #374151;">وصفة طبية #{{ $prescription->id }}</h4>
                        <span style="font-size: 12px; color: #6B7280;">{{ $prescription->created_at->format('d/m/Y') }}</span>
                    </div>
                    @if($prescription->medications->count() > 0)
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: #374151; font-size: 14px;">الأدوية:</span>
                            <ul style="margin: 5px 0 0 20px; padding: 0;">
                                @foreach($prescription->medications as $medication)
                                    <li style="color: #6B7280; font-size: 14px;">{{ $medication->name }} - {{ $medication->dosage }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($prescription->notes)
                        <div>
                            <span style="font-weight: bold; color: #374151; font-size: 14px;">ملاحظات:</span>
                            <span style="color: #6B7280; font-size: 14px;">{{ $prescription->notes }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <p style="text-align: center; color: #6B7280; padding: 20px;">لا توجد وصفات طبية</p>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>تم إنشاء هذا التقرير في {{ now()->format('d/m/Y H:i') }}</p>
        <p>مستشفى الإدارة الطبية - نظام إدارة المستشفى</p>
    </div>
</body>
</html>
