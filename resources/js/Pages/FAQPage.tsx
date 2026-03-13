import { PageLayout } from '@/Components/layout/PageLayout';
import { useMemo, useState } from 'react';

interface FAQItem {
    question: string;
    answer: string;
}

interface FAQCategory {
    title: string;
    items: FAQItem[];
}

const FAQ_DATA: FAQCategory[] = [
    {
        title: 'Tentang Layanan',
        items: [
            {
                question: 'Apa itu platform OnlineConsultant?',
                answer: 'Platform yang menghubungkan Anda dengan konselor profesional untuk konsultasi online dan offline. Kami menyediakan layanan yang aman, terpercaya, dan mudah diakses dari mana saja.',
            },
            {
                question: 'Bagaimana cara mulai menggunakan layanan ini?',
                answer: 'Daftar akun, verifikasi email, pilih konselor yang sesuai dengan kebutuhan Anda, atur jadwal konsultasi, dan lakukan pembayaran. Proses ini dirancang sesederhana mungkin agar Anda bisa segera mendapatkan bantuan.',
            },
            {
                question: 'Apakah data saya aman?',
                answer: 'Ya, kami menggunakan enkripsi SSL/TLS untuk melindungi seluruh data Anda. Hanya Anda dan konselor yang dapat mengakses informasi konsultasi. Privasi Anda adalah prioritas utama kami.',
            },
        ],
    },
    {
        title: 'Booking & Jadwal',
        items: [
            {
                question: 'Bagaimana cara melakukan booking konsultasi?',
                answer: 'Pilih konselor → pilih jadwal yang tersedia → pilih tipe konsultasi (online/offline) → lakukan pembayaran. Setelah booking selesai, Anda akan menerima konfirmasi via email beserta detail jadwal.',
            },
            {
                question: 'Bisakah saya mengubah jadwal konsultasi?',
                answer: 'Ya, Anda dapat mengajukan reschedule minimal 24 jam sebelum jadwal konsultasi. Perubahan jadwal harus disetujui oleh konselor dan tidak dikenakan biaya tambahan.',
            },
            {
                question: 'Apa makna dari setiap status booking?',
                answer: 'Pending Payment = menunggu pembayaran | Paid = pembayaran berhasil, menunggu sesi | Completed = sesi konsultasi telah selesai | Cancelled = booking dibatalkan | Rescheduled = jadwal telah diubah.',
            },
            {
                question: 'Berapa durasi satu sesi konsultasi?',
                answer: 'Durasi standar sesi konsultasi adalah 1 jam. Untuk kebutuhan khusus, tersedia opsi durasi 2 jam yang bisa dipilih saat booking.',
            },
        ],
    },
    {
        title: 'Pembayaran & Refund',
        items: [
            {
                question: 'Metode pembayaran apa saja yang diterima?',
                answer: 'Kami menerima berbagai metode pembayaran melalui Midtrans, termasuk transfer bank, e-wallet (GoPay, OVO, Dana), kartu kredit/debit, dan virtual account dari berbagai bank.',
            },
            {
                question: 'Berapa lama batas waktu pembayaran?',
                answer: 'Anda memiliki waktu 24 jam untuk menyelesaikan pembayaran setelah booking. Jika melewati batas waktu, booking akan otomatis dibatalkan dan jadwal konselor kembali tersedia untuk pengguna lain.',
            },
            {
                question: 'Bagaimana kebijakan refund jika saya membatalkan?',
                answer: 'Refund diberikan jika pembatalan dilakukan minimal 24 jam sebelum jadwal konsultasi. Pembatalan yang dilakukan kurang dari 24 jam sebelum jadwal tidak dapat direfund. Proses pengembalian dana membutuhkan waktu 3-7 hari kerja.',
            },
        ],
    },
    {
        title: 'Konselor',
        items: [
            {
                question: 'Apakah konselor di platform ini terverifikasi?',
                answer: 'Ya, semua konselor telah melalui proses verifikasi ketat. Mereka memiliki sertifikasi profesional, minimal lulusan S1 Psikologi, dan pengalaman praktik minimal 2 tahun di bidangnya.',
            },
            {
                question:
                    'Bisakah saya memilih konselor yang sama untuk sesi berikutnya?',
                answer: 'Tentu saja. Anda dapat melakukan booking kembali dengan konselor yang sama untuk menjaga kontinuitas dan kualitas konsultasi Anda.',
            },
            {
                question:
                    'Bagaimana cara melihat jadwal ketersediaan konselor?',
                answer: 'Kunjungi halaman profil konselor untuk melihat jadwal ketersediaan, spesialisasi, harga, dan ulasan dari klien sebelumnya. Anda bisa langsung memilih jadwal yang sesuai.',
            },
        ],
    },
    {
        title: 'Bantuan & Kontak',
        items: [
            {
                question: 'Bagaimana jika saya mengalami masalah teknis?',
                answer: 'Coba refresh halaman atau bersihkan cache browser Anda terlebih dahulu. Jika masalah masih berlanjut, silakan hubungi tim customer service kami melalui WhatsApp atau email.',
            },
            {
                question: 'Bagaimana cara menghubungi customer service?',
                answer: 'Anda bisa menghubungi kami melalui WhatsApp di +62 812-3456-7890 atau email di support@personaquality.com. Jam operasional: Senin-Jumat, 09.00 - 17.00 WIB.',
            },
            {
                question: 'Berapa lama waktu respon customer service?',
                answer: 'Kami berusaha merespon dalam waktu maksimal 2 jam selama jam kerja. Untuk email yang masuk di luar jam kerja, kami akan merespon dalam 1x24 jam.',
            },
        ],
    },
];

function AccordionItem({
    item,
    isOpen,
    onToggle,
}: {
    item: FAQItem;
    isOpen: boolean;
    onToggle: () => void;
}) {
    return (
        <div className="border-b border-slate-200/80">
            <button
                onClick={onToggle}
                className="group flex w-full cursor-pointer items-center justify-between py-6 pr-4 text-left outline-none lg:py-7"
            >
                <h3 className="text-base font-medium text-slate-900 transition-colors group-hover:text-primary md:text-lg">
                    {item.question}
                </h3>
                <span
                    className={`ml-4 flex h-6 w-6 shrink-0 items-center justify-center text-slate-400 transition-all duration-300 group-hover:text-primary ${
                        isOpen ? 'rotate-45' : ''
                    }`}
                >
                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        stroke="currentColor"
                        strokeWidth="2"
                        strokeLinecap="round"
                    >
                        <line x1="8" y1="2" x2="8" y2="14" />
                        <line x1="2" y1="8" x2="14" y2="8" />
                    </svg>
                </span>
            </button>

            <div
                className={`overflow-hidden transition-all duration-300 ease-in-out ${
                    isOpen ? 'max-h-96 pb-6 opacity-100' : 'max-h-0 opacity-0'
                }`}
            >
                <p className="pr-8 leading-relaxed text-slate-500">
                    {item.answer}
                </p>
            </div>
        </div>
    );
}

export default function FAQPage() {
    const [openIndex, setOpenIndex] = useState<string | null>('0-0');
    const [searchQuery, setSearchQuery] = useState('');

    const filteredCategories = useMemo(() => {
        if (!searchQuery.trim()) return FAQ_DATA;

        const query = searchQuery.toLowerCase();
        return FAQ_DATA.map((category) => ({
            ...category,
            items: category.items.filter(
                (item) =>
                    item.question.toLowerCase().includes(query) ||
                    item.answer.toLowerCase().includes(query),
            ),
        })).filter((category) => category.items.length > 0);
    }, [searchQuery]);

    const totalResults = useMemo(
        () =>
            filteredCategories.reduce((sum, cat) => sum + cat.items.length, 0),
        [filteredCategories],
    );

    const toggleFAQ = (id: string) => {
        setOpenIndex(openIndex === id ? null : id);
    };

    return (
        <PageLayout>
            <div className="font-poppins">
                <main className="mx-auto w-full max-w-7xl px-6 py-12 md:py-20 lg:py-24">
                    <div className="flex flex-col gap-12 lg:flex-row lg:gap-24">
                        {/* Left Column: Sticky Header & Search */}
                        <div className="flex flex-col gap-8 lg:w-1/3">
                            <div className="flex flex-col gap-6 lg:sticky lg:top-32">
                                <div className="space-y-4">
                                    <span className="text-xs font-medium uppercase tracking-widest text-primary">
                                        Pusat Bantuan
                                    </span>
                                    <h1 className="text-4xl font-bold leading-tight text-slate-900 md:text-5xl lg:text-6xl lg:leading-[1.1]">
                                        Pertanyaan
                                        <br />
                                        yang Sering
                                        <br />
                                        Ditanyakan
                                    </h1>
                                    <p className="max-w-sm text-lg leading-relaxed text-slate-500">
                                        Temukan jawaban seputar layanan
                                        konsultasi, pembayaran, jadwal, dan
                                        kebijakan kami.
                                    </p>
                                </div>

                                {/* Search Input */}
                                <div className="group relative w-full max-w-sm">
                                    <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-1">
                                        <svg
                                            className="h-5 w-5 text-slate-400 transition-colors group-focus-within:text-primary"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            strokeWidth={2}
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                            />
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        value={searchQuery}
                                        onChange={(e) =>
                                            setSearchQuery(e.target.value)
                                        }
                                        className="block w-full border-0 border-b-2 border-slate-200 bg-transparent py-3 pl-8 pr-3 text-base text-slate-900 placeholder-slate-400 transition-all focus:border-primary focus:outline-none focus:ring-0"
                                        placeholder="Cari pertanyaan..."
                                    />
                                </div>

                                {searchQuery && (
                                    <p className="text-sm text-slate-400">
                                        {totalResults} hasil ditemukan
                                    </p>
                                )}

                                {/* Decorative line */}
                                <div className="mt-8 hidden h-1 w-12 bg-primary/20 lg:block" />
                            </div>
                        </div>

                        {/* Right Column: Accordion */}
                        <div className="lg:w-2/3 lg:pt-10">
                            {filteredCategories.length === 0 ? (
                                <div className="py-16 text-center">
                                    <p className="text-lg text-slate-400">
                                        Tidak ada hasil untuk "{searchQuery}"
                                    </p>
                                    <button
                                        onClick={() => setSearchQuery('')}
                                        className="mt-4 text-sm font-medium text-primary hover:underline"
                                    >
                                        Reset pencarian
                                    </button>
                                </div>
                            ) : (
                                <div className="space-y-10">
                                    {filteredCategories.map(
                                        (category, catIdx) => (
                                            <div key={catIdx}>
                                                <h2 className="mb-2 text-xs font-bold uppercase tracking-widest text-primary/60">
                                                    {category.title}
                                                </h2>
                                                <div>
                                                    {category.items.map(
                                                        (item, itemIdx) => {
                                                            const id = `${catIdx}-${itemIdx}`;
                                                            return (
                                                                <AccordionItem
                                                                    key={id}
                                                                    item={item}
                                                                    isOpen={
                                                                        openIndex ===
                                                                        id
                                                                    }
                                                                    onToggle={() =>
                                                                        toggleFAQ(
                                                                            id,
                                                                        )
                                                                    }
                                                                />
                                                            );
                                                        },
                                                    )}
                                                </div>
                                            </div>
                                        ),
                                    )}
                                </div>
                            )}
                        </div>
                    </div>
                </main>

                {/* CTA Banner */}
                <section className="border-t border-slate-200/80 bg-white">
                    <div className="mx-auto flex max-w-7xl flex-col items-center justify-between gap-8 px-6 py-16 md:flex-row md:py-24">
                        <div className="flex flex-col gap-2 md:max-w-xl">
                            <h2 className="text-3xl font-bold text-slate-900">
                                Masih ada pertanyaan?
                            </h2>
                            <p className="text-lg text-slate-500">
                                Kami memahami bahwa mencari bantuan adalah
                                langkah besar. Jika Anda tidak menemukan jawaban
                                yang dicari, tim kami siap membantu.
                            </p>
                        </div>
                        <div className="flex shrink-0 gap-3">
                            <a
                                href="https://wa.me/6281234567890"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="inline-flex items-center justify-center gap-2 rounded-full border-2 border-primary bg-primary px-8 py-3 text-base font-semibold text-white transition-all duration-300 hover:bg-primary/90"
                            >
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </PageLayout>
    );
}
