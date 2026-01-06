import { Booking } from '@/Interfaces';

// PDF Colors Configuration
const PDF_COLORS = {
    primary: [128, 0, 32] as [number, number, number], // Maroon Red
    secondary: [34, 197, 94] as [number, number, number], // Green
    gray: [107, 114, 128] as [number, number, number],
    lightGray: [243, 244, 246] as [number, number, number],
    white: [255, 255, 255] as [number, number, number],
    warning: [251, 191, 36] as [number, number, number],
    danger: [239, 68, 68] as [number, number, number],
};

/**
 * Helper function to draw a section header in PDF
 */
const drawSectionHeader = (
    doc: import('jspdf').jsPDF,
    title: string,
    yPos: number,
    margin: number,
    contentWidth: number,
): number => {
    doc.setFillColor(...PDF_COLORS.primary);
    doc.rect(margin, yPos, contentWidth, 8, 'F');
    doc.setFontSize(11);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(255, 255, 255);
    doc.text(title, margin + 4, yPos + 5.5);
    doc.setTextColor(0, 0, 0);
    return yPos + 12;
};

/**
 * Helper function to draw a row in PDF
 */
const drawRow = (
    doc: import('jspdf').jsPDF,
    label: string,
    value: string,
    yPos: number,
    margin: number,
    contentWidth: number,
    isAlt: boolean = false,
): number => {
    if (isAlt) {
        doc.setFillColor(...PDF_COLORS.lightGray);
        doc.rect(margin, yPos - 4, contentWidth, 7, 'F');
    }
    doc.setFontSize(10);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(...PDF_COLORS.gray);
    doc.text(label, margin + 4, yPos);
    doc.setFont('helvetica', 'normal');
    doc.setTextColor(0, 0, 0);
    doc.text(value, margin + 55, yPos);
    return yPos + 7;
};

/**
 * Helper function to draw right column row in PDF
 */
const drawRightRow = (
    doc: import('jspdf').jsPDF,
    label: string,
    value: string,
    yPos: number,
    rightX: number,
    colWidth: number,
    isAlt: boolean = false,
): number => {
    if (isAlt) {
        doc.setFillColor(...PDF_COLORS.lightGray);
        doc.rect(rightX, yPos - 4, colWidth, 7, 'F');
    }
    doc.setFontSize(10);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(...PDF_COLORS.gray);
    doc.text(label, rightX + 4, yPos);
    doc.setFont('helvetica', 'normal');
    doc.setTextColor(0, 0, 0);
    const maxWidth = colWidth - 55;
    const truncatedValue =
        doc.getTextWidth(value) > maxWidth
            ? value.substring(0, 20) + '...'
            : value;
    doc.text(truncatedValue, rightX + 45, yPos);
    return yPos + 7;
};

/**
 * Generate PDF document for a booking
 */
export const generateBookingPdf = async (
    booking: Booking,
    formatCurrency: (amount: number) => string,
    formatStatus: (status: string) => string,
): Promise<void> => {
    const { jsPDF } = await import('jspdf');
    const doc = new jsPDF();

    const pageWidth = doc.internal.pageSize.getWidth();
    const margin = 15;
    const contentWidth = pageWidth - margin * 2;
    let y = 15;

    // ===== HEADER =====
    doc.setFillColor(...PDF_COLORS.primary);
    doc.rect(0, 0, pageWidth, 35, 'F');

    doc.setFontSize(18);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(255, 255, 255);
    doc.text('BUKTI BOOKING KONSULTASI', pageWidth / 2, 15, {
        align: 'center',
    });

    doc.setFontSize(10);
    doc.setFont('helvetica', 'normal');
    doc.text(`No. Booking: #${booking.id}`, pageWidth / 2, 24, {
        align: 'center',
    });

    // Status Badge
    const statusText = formatStatus(booking.status);
    const statusWidth = doc.getTextWidth(statusText) + 12;
    const statusX = (pageWidth - statusWidth) / 2;

    if (booking.status === 'paid' || booking.status === 'completed') {
        doc.setFillColor(...PDF_COLORS.secondary);
    } else if (booking.status === 'cancelled') {
        doc.setFillColor(...PDF_COLORS.danger);
    } else {
        doc.setFillColor(...PDF_COLORS.warning);
    }
    doc.roundedRect(statusX, 27, statusWidth, 6, 2, 2, 'F');
    doc.setFontSize(8);
    doc.setTextColor(255, 255, 255);
    doc.text(statusText.toUpperCase(), pageWidth / 2, 31, {
        align: 'center',
    });

    doc.setTextColor(0, 0, 0);
    y = 45;

    // ===== INFO BOOKING & JADWAL =====
    const colWidth = contentWidth / 2 - 3;

    // Left column - Info Klien
    let leftY = drawSectionHeader(doc, 'DATA KLIEN', y, margin, colWidth);
    doc.setDrawColor(220, 220, 220);
    doc.rect(margin, leftY - 4, colWidth, 28, 'S');

    leftY = drawRow(
        doc,
        'Nama',
        booking.client.name,
        leftY,
        margin,
        colWidth,
        true,
    );
    leftY = drawRow(
        doc,
        'Email',
        booking.client.email,
        leftY,
        margin,
        colWidth,
    );
    leftY = drawRow(
        doc,
        'Telepon',
        booking.client.phone || '-',
        leftY,
        margin,
        colWidth,
        true,
    );

    // Right column - Info Counselor
    const rightX = margin + colWidth + 6;
    let rightY = y;
    doc.setFillColor(...PDF_COLORS.primary);
    doc.rect(rightX, rightY, colWidth, 8, 'F');
    doc.setFontSize(11);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(255, 255, 255);
    doc.text('DATA COUNSELOR', rightX + 4, rightY + 5.5);
    doc.setTextColor(0, 0, 0);
    rightY += 12;

    doc.setDrawColor(220, 220, 220);
    doc.rect(rightX, rightY - 4, colWidth, 28, 'S');

    rightY = drawRightRow(
        doc,
        'Nama',
        booking.counselor.user.name,
        rightY,
        rightX,
        colWidth,
        true,
    );
    rightY = drawRightRow(
        doc,
        'Spesialisasi',
        booking.counselor.specialization,
        rightY,
        rightX,
        colWidth,
    );
    rightY = drawRightRow(
        doc,
        'Pendidikan',
        booking.counselor.education,
        rightY,
        rightX,
        colWidth,
        true,
    );

    y = Math.max(leftY, rightY) + 10;

    // ===== DETAIL BOOKING =====
    y = drawSectionHeader(
        doc,
        'DETAIL JADWAL KONSULTASI',
        y,
        margin,
        contentWidth,
    );
    doc.setDrawColor(220, 220, 220);
    doc.rect(margin, y - 4, contentWidth, 35, 'S');

    const scheduleDate = new Date(booking.schedule.date).toLocaleDateString(
        'id-ID',
        {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        },
    );
    const startTime = booking.schedule.start_time.substring(0, 5);
    const endTime = booking.schedule.end_time.substring(0, 5);
    const consultationType =
        booking.consultation_type === 'online' ? 'Online' : 'Offline';

    y = drawRow(doc, 'Tanggal', scheduleDate, y, margin, contentWidth, true);
    y = drawRow(
        doc,
        'Waktu',
        `${startTime} - ${endTime} WIB`,
        y,
        margin,
        contentWidth,
    );
    y = drawRow(
        doc,
        'Durasi',
        `${booking.duration_hours} Jam`,
        y,
        margin,
        contentWidth,
        true,
    );
    y = drawRow(doc, 'Tipe', consultationType, y, margin, contentWidth);
    y = drawRow(
        doc,
        'Biaya',
        formatCurrency(booking.price),
        y,
        margin,
        contentWidth,
        true,
    );

    y += 10;

    // ===== DATA PEMBAYARAN =====
    if (booking.payment) {
        y = drawSectionHeader(
            doc,
            'INFORMASI PEMBAYARAN',
            y,
            margin,
            contentWidth,
        );

        const paymentRows = 4 + (booking.payment.paid_at ? 1 : 0);
        doc.setDrawColor(220, 220, 220);
        doc.rect(margin, y - 4, contentWidth, paymentRows * 7, 'S');

        const paymentStatus =
            booking.payment.status === 'paid'
                ? '✓ LUNAS'
                : booking.payment.status === 'pending'
                  ? '⏳ Menunggu Pembayaran'
                  : formatStatus(booking.payment.status);

        y = drawRow(
            doc,
            'Order ID',
            booking.payment.order_id,
            y,
            margin,
            contentWidth,
            true,
        );
        y = drawRow(doc, 'Status', paymentStatus, y, margin, contentWidth);

        if (booking.payment.payment_type) {
            y = drawRow(
                doc,
                'Metode',
                booking.payment.payment_type.toUpperCase(),
                y,
                margin,
                contentWidth,
                true,
            );
        }

        y = drawRow(
            doc,
            'Total Bayar',
            formatCurrency(booking.payment.amount),
            y,
            margin,
            contentWidth,
        );

        if (booking.payment.paid_at) {
            const paidAt = new Date(booking.payment.paid_at).toLocaleString(
                'id-ID',
            );
            y = drawRow(
                doc,
                'Dibayar pada',
                paidAt,
                y,
                margin,
                contentWidth,
                true,
            );
        }

        y += 10;
    }

    // ===== CATATAN =====
    if (booking.notes) {
        y = drawSectionHeader(doc, 'CATATAN', y, margin, contentWidth);
        doc.setDrawColor(220, 220, 220);

        doc.setFontSize(10);
        doc.setFont('helvetica', 'normal');
        const splitNotes = doc.splitTextToSize(booking.notes, contentWidth - 8);
        const notesHeight = splitNotes.length * 5 + 6;

        doc.rect(margin, y - 4, contentWidth, notesHeight, 'S');
        doc.text(splitNotes, margin + 4, y);
        y += notesHeight + 6;
    }

    // ===== FOOTER =====
    const footerY = doc.internal.pageSize.getHeight() - 20;

    // Gradient line effect
    doc.setDrawColor(...PDF_COLORS.primary);
    doc.setLineWidth(0.5);
    doc.line(margin, footerY - 5, pageWidth - margin, footerY - 5);

    doc.setFontSize(8);
    doc.setTextColor(...PDF_COLORS.gray);
    doc.setFont('helvetica', 'italic');
    doc.text(
        `Dokumen ini dicetak secara otomatis pada ${new Date().toLocaleString('id-ID')}`,
        pageWidth / 2,
        footerY,
        { align: 'center' },
    );

    doc.setFont('helvetica', 'normal');
    doc.text(
        'Terima kasih telah menggunakan layanan kami',
        pageWidth / 2,
        footerY + 5,
        { align: 'center' },
    );

    // Save PDF
    doc.save(`bukti-booking-${booking.id}.pdf`);
};
