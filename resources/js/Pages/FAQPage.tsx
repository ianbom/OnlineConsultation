import { PageLayout } from "@/Components/layout/PageLayout";
import { useState } from "react";

interface FAQItem {
  question: string;
  answer: string;
}

interface FAQCategory {
  title: string;
  icon: string;
  items: FAQItem[];
}

export default function FAQPage() {
  const [openIndex, setOpenIndex] = useState<string | null>(null);

  const faqData: FAQCategory[] = [
    {
      title: "Tentang Layanan",
      icon: "",
      items: [
        {
          question: "Apa itu platform OnlineConsultant?",
          answer: "Platform yang menghubungkan Anda dengan konselor profesional untuk konsultasi online dan offline."
        },
        {
          question: "Bagaimana cara mulai menggunakan?",
          answer: "Daftar akun, verifikasi email, pilih konselor, atur jadwal, dan lakukan pembayaran."
        },
        {
          question: "Apakah data saya aman?",
          answer: "Ya, kami menggunakan enkripsi SSL/TLS. Hanya Anda dan konselor yang dapat mengakses informasi konsultasi."
        }
      ]
    },
    {
      title: "Booking & Jadwal",
      icon: "",
      items: [
        {
          question: "Bagaimana cara melakukan booking?",
          answer: "Pilih konselor → pilih jadwal → pilih tipe (online/offline) → bayar. Booking selesai dan Anda akan menerima konfirmasi via email."
        },
        {
          question: "Bisakah saya mengubah jadwal konsultasi?",
          answer: "Ya, ajukan reschedule minimal 24 jam sebelum jadwal. Konselor harus menyetujui perubahan tersebut. Tidak ada biaya tambahan."
        },
        {
          question: "Apa makna status booking?",
          answer: "Pending = menunggu pembayaran | Paid = sudah dibayar | Completed = selesai | Cancelled = dibatalkan"
        }
      ]
    },
    {
      title: "Pembayaran & Refund",
      icon: "",
      items: [
        {
          question: "Metode pembayaran apa saja yang diterima?",
          answer: "Transfer bank, e-wallet (GoPay, OVO, Dana), kartu kredit/debit, dan virtual account melalui Midtrans."
        },
        {
          question: "Berapa lama waktu pembayaran?",
          answer: "Anda memiliki 24 jam untuk membayar. Jika expired, booking otomatis dibatalkan dan jadwal kembali tersedia."
        },
        {
          question: "Bagaimana kebijakan refund?",
          answer: "Refund diberikan jika pembatalan dilakukan minimal 24 jam sebelum jadwal. Pembatalan kurang dari 24 jam tidak dapat direfund. Dana masuk 3-7 hari kerja."
        }
      ]
    },
    {
      title: "Konselor",
      icon: "",
      items: [
        {
          question: "Apakah konselor terverifikasi?",
          answer: "Ya, semua konselor memiliki sertifikasi profesional, minimal S1 Psikologi, dan pengalaman minimal 2 tahun."
        },
        {
          question: "Bisakah saya memilih konselor yang sama lagi?",
          answer: "Ya, Anda dapat melakukan booking dengan konselor yang sama untuk menjaga kontinuitas konsultasi."
        },
        {
          question: "Bagaimana melihat jadwal konselor?",
          answer: "Lihat profil konselor untuk melihat jadwal ketersediaan dan spesialisasi mereka."
        }
      ]
    },
    {
      title: "Bantuan & Kontak",
      icon: "",
      items: [
        {
          question: "Bagaimana jika ada masalah teknis?",
          answer: "Coba refresh halaman atau clear cache browser. Jika masalah berlanjut, hubungi customer service kami."
        },
        {
          question: "Bagaimana menghubungi customer service?",
          answer: "WhatsApp: +62 812-3456-7890 | Email: support@personaquality.com | Jam kerja: Senin-Jumat 09.00-17.00 WIB"
        },
        {
          question: "Berapa lama waktu respon?",
          answer: "Kami merespon dalam 2 jam pada jam kerja, atau 1x24 jam untuk email."
        }
      ]
    }
  ];

  const toggleFAQ = (index: string) => {
    setOpenIndex(openIndex === index ? null : index);
  };

  return (
    <PageLayout
      title="Frequently Asked Questions (FAQ)"
      description="Temukan jawaban atas pertanyaan yang sering diajukan tentang layanan kami"
    >
      <div className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12 px-4">
        <div className="max-w-5xl mx-auto">
          {/* Header Section */}
          {/* FAQ Grid */}
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
            {faqData.map((category, categoryIndex) => (
              <div
                key={categoryIndex}
                className="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100"
              >
                {/* Category Header */}
                <div className="bg-primary text-white px-6 py-5">
                  <h2 className="text-lg font-bold flex items-center gap-3">
                    <span className="text-3xl">{category.icon}</span>
                    <span>{category.title}</span>
                  </h2>
                </div>

                {/* FAQ Items */}
                <div className="divide-y divide-gray-100">
                  {category.items.map((item, itemIndex) => {
                    const faqId = `${categoryIndex}-${itemIndex}`;
                    const isOpen = openIndex === faqId;

                    return (
                      <div
                        key={itemIndex}
                        className="border-0"
                      >
                        <button
                          onClick={() => toggleFAQ(faqId)}
                          className="w-full px-6 py-4 text-left hover:bg-primary/10 transition-all duration-200 flex justify-between items-start gap-4 group"
                        >
                          <span className="font-semibold text-gray-800 flex-1 group-hover:text-primary transition-colors text-sm">
                            {item.question}
                          </span>
                          <div className="flex-shrink-0 mt-0.5">
                            <svg
                              className={`w-5 h-5 text-primary transition-transform duration-300 ${
                                isOpen ? "transform rotate-180" : ""
                              }`}
                              fill="none"
                              viewBox="0 0 24 24"
                              stroke="currentColor"
                              strokeWidth={2.5}
                            >
                              <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M19 9l-7 7-7-7"
                              />
                            </svg>
                          </div>
                        </button>

                        {isOpen && (
                          <div className="px-6 pb-4 bg-primary/10 animate-fadeIn">
                            <p className="text-gray-700 text-sm leading-relaxed">
                              {item.answer}
                            </p>
                          </div>
                        )}
                      </div>
                    );
                  })}
                </div>
              </div>
            ))}
          </div>

        {/* Contact Section */}
        <div className="mt-16 bg-gradient-to-r from-primary via-primary to-primary rounded-2xl p-10 text-center text-white shadow-xl">
          <div className="mb-6">
            <h3 className="text-3xl font-bold mb-3">
              Masih Ada Pertanyaan?
            </h3>
            <p className="text-primary/20 text-lg">
              Tim customer service kami siap membantu Anda 24/7
            </p>
          </div>

          <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a
              href="https://wa.me/6281234567890"
              target="_blank"
              rel="noopener noreferrer"
              className="inline-flex items-center gap-3 bg-white text-green-600 font-semibold px-8 py-4 rounded-lg hover:bg-gray-50 transition-all duration-200 transform hover:scale-105 shadow-lg"
            >
              <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
              WhatsApp
            </a>
            <a
              href="mailto:support@personaquality.com"
              className="inline-flex items-center gap-3 bg-white text-primary font-semibold px-8 py-4 rounded-lg hover:bg-gray-50 transition-all duration-200 transform hover:scale-105 shadow-lg"
            >
              <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              Email
            </a>
          </div>

          <p className="text-white text-sm mt-6">
            📞 Senin-Jumat: 09.00 - 17.00 WIB
          </p>
        </div>
        </div>
      </div>

      <style>{`
        @keyframes fadeIn {
          from {
            opacity: 0;
            max-height: 0;
          }
          to {
            opacity: 1;
            max-height: 500px;
          }
        }

        .animate-fadeIn {
          animation: fadeIn 0.3s ease-out;
        }
      `}</style>
    </PageLayout>
  );
}
