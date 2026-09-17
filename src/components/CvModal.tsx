import React from 'react';
import { 
  FileDown, 
  Printer, 
  X, 
  Mail, 
  Phone, 
  MapPin, 
  GraduationCap, 
  Code, 
  Palette, 
  CheckCircle2,
  Calendar
} from 'lucide-react';
import { PERSONAL_INFO, SKILLS_DATA, EDUCATION_DATA } from '../data/portfolioData';

interface CvModalProps {
  isOpen: boolean;
  onClose: () => void;
}

export const CvModal: React.FC<CvModalProps> = ({ isOpen, onClose }) => {
  if (!isOpen) return null;

  const handlePrint = () => {
    window.print();
  };

  const handleDownload = () => {
    // Generate a clean text / blob CV or trigger download
    const cvContent = `
RASINDU NAWOD
Web Developer | Graphic Designer
Location: Sri Lanka | Matara | Akuressa
Phone/WhatsApp: +94 74 123 4567
Email: ${PERSONAL_INFO.email}

PROFILE SUMMARY
I am Rasindu Nawod, a passionate Web Developer and Graphic Designer from Sri Lanka, focused on creating modern websites, creative visual designs and digital experiences.

EDUCATION JOURNEY
- 2024: Rahula College, Matara - Completed School Education (A/L Examination)
- 2024: IMS Campus - Graphic Design Course (Adobe Illustrator, Adobe Photoshop)
- Current: ICBT Campus - Diploma in Computer and Software Engineering (Studying)

TECHNICAL & PROGRAMMING SKILLS
- HTML5 (Advanced)
- CSS3 & Tailwind CSS (Advanced)
- JavaScript (Intermediate)
- PHP 8+ & MySQL (Intermediate)
- Java (Learning)

GRAPHIC DESIGN TOOLS
- Adobe Illustrator (Advanced Vector, Logos, Typography)
- Adobe Photoshop (Photo Editing, Banners, Digital Art)

LANGUAGES
- Sinhala (Native)
- English (Professional Working)
    `.trim();

    const blob = new Blob([cvContent], { type: 'text/plain;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'Rasindu-Nawod-CV.txt';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  };

  return (
    <div
      className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-950/80 backdrop-blur-sm animate-fade-in"
      role="dialog"
      aria-modal="true"
    >
      <div className="bg-white dark:bg-[#151722] rounded-3xl max-w-3xl w-full max-h-[92vh] overflow-y-auto border border-neutral-200 dark:border-neutral-800 shadow-2xl relative flex flex-col">
        
        {/* Modal Header Controls */}
        <div className="p-4 sm:p-6 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between sticky top-0 bg-white/95 dark:bg-[#151722]/95 backdrop-blur-md z-10">
          <div className="flex items-center gap-2">
            <div className="w-8 h-8 rounded-lg bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center font-bold text-sm">
              CV
            </div>
            <div>
              <h3 className="text-sm sm:text-base font-bold font-heading text-neutral-900 dark:text-white">
                Curriculum Vitae • Rasindu Nawod
              </h3>
              <p className="text-[11px] text-neutral-500">
                Official Portfolio Resume
              </p>
            </div>
          </div>

          <div className="flex items-center gap-2">
            <button
              onClick={handlePrint}
              className="p-2 rounded-xl text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer"
              title="Print CV"
            >
              <Printer className="w-4 h-4" />
            </button>
            <button
              onClick={handleDownload}
              className="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 transition-colors cursor-pointer"
              title="Download CV"
            >
              <FileDown className="w-3.5 h-3.5" />
              <span>Download CV</span>
            </button>
            <button
              onClick={onClose}
              className="p-2 rounded-xl text-neutral-500 hover:text-neutral-900 dark:hover:text-white transition-colors cursor-pointer"
              aria-label="Close"
            >
              <X className="w-5 h-5" />
            </button>
          </div>
        </div>

        {/* Printable CV Document Content */}
        <div id="printable-cv-content" className="p-6 sm:p-10 space-y-8 text-neutral-800 dark:text-neutral-200 text-sm">
          
          {/* Header */}
          <div className="border-b border-neutral-200 dark:border-neutral-800 pb-6 flex flex-col sm:flex-row justify-between gap-4">
            <div>
              <h1 className="text-2xl sm:text-3xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
                Rasindu Nawod
              </h1>
              <p className="text-sm font-semibold text-rose-600 dark:text-rose-400 mt-0.5">
                Web Developer | Graphic Designer
              </p>
              <p className="text-xs text-neutral-500 dark:text-neutral-400 mt-2 max-w-md">
                Passionate Sri Lankan creator combining coding logic with visual elegance to develop responsive websites and brand graphics.
              </p>
            </div>

            <div className="space-y-1 text-xs text-neutral-600 dark:text-neutral-400 shrink-0">
              <div className="flex items-center gap-2">
                <MapPin className="w-3.5 h-3.5 text-rose-500" />
                <span>Matara, Akuressa, Sri Lanka</span>
              </div>
              <div className="flex items-center gap-2">
                <Phone className="w-3.5 h-3.5 text-rose-500" />
                <span>+94 74 123 4567</span>
              </div>
              <div className="flex items-center gap-2">
                <Mail className="w-3.5 h-3.5 text-rose-500" />
                <span>{PERSONAL_INFO.email}</span>
              </div>
            </div>
          </div>

          {/* Education Journey */}
          <div>
            <h2 className="text-sm font-bold uppercase tracking-wider text-rose-600 dark:text-rose-400 mb-3 flex items-center gap-2">
              <GraduationCap className="w-4 h-4" />
              <span>Education & Qualifications</span>
            </h2>
            <div className="space-y-4">
              {EDUCATION_DATA.filter(e => e.status !== 'Future Goal').map((edu) => (
                <div key={edu.id} className="p-4 rounded-xl bg-neutral-50 dark:bg-neutral-900/60 border border-neutral-200/80 dark:border-neutral-800">
                  <div className="flex justify-between items-start gap-2">
                    <div>
                      <h3 className="font-bold text-neutral-900 dark:text-white text-sm">
                        {edu.title}
                      </h3>
                      <p className="text-xs font-semibold text-neutral-600 dark:text-neutral-400">
                        {edu.institution}
                      </p>
                    </div>
                    <span className="text-xs font-code font-bold text-rose-500 bg-rose-50 dark:bg-rose-950/40 px-2 py-0.5 rounded-md">
                      {edu.year}
                    </span>
                  </div>
                  <p className="text-xs text-neutral-600 dark:text-neutral-400 mt-2">
                    {edu.description}
                  </p>
                </div>
              ))}
            </div>
          </div>

          {/* Technical Skills */}
          <div>
            <h2 className="text-sm font-bold uppercase tracking-wider text-rose-600 dark:text-rose-400 mb-3 flex items-center gap-2">
              <Code className="w-4 h-4" />
              <span>Technical Skills (Development)</span>
            </h2>
            <div className="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
              {SKILLS_DATA.filter(s => s.category === 'Development').map((s) => (
                <div key={s.name} className="p-2.5 rounded-lg bg-neutral-50 dark:bg-neutral-900/60 border border-neutral-200 dark:border-neutral-800 text-xs">
                  <span className="font-bold text-neutral-900 dark:text-white block">{s.name}</span>
                  <span className="text-[11px] text-neutral-500">{s.proficiency}</span>
                </div>
              ))}
            </div>
          </div>

          {/* Design Skills */}
          <div>
            <h2 className="text-sm font-bold uppercase tracking-wider text-rose-600 dark:text-rose-400 mb-3 flex items-center gap-2">
              <Palette className="w-4 h-4" />
              <span>Graphic Design Tools & Media</span>
            </h2>
            <div className="grid grid-cols-2 gap-2.5">
              {SKILLS_DATA.filter(s => s.category === 'Design').map((s) => (
                <div key={s.name} className="p-2.5 rounded-lg bg-neutral-50 dark:bg-neutral-900/60 border border-neutral-200 dark:border-neutral-800 text-xs">
                  <span className="font-bold text-neutral-900 dark:text-white block">{s.name}</span>
                  <span className="text-[11px] text-neutral-500">{s.proficiency}</span>
                </div>
              ))}
            </div>
          </div>

        </div>

        {/* Modal Footer */}
        <div className="p-4 sm:p-6 border-t border-neutral-200 dark:border-neutral-800 bg-neutral-50 dark:bg-neutral-900/50 flex justify-between items-center text-xs text-neutral-500">
          <span>Path config: /assets/cv/Rasindu-Nawod-CV.pdf</span>
          <button
            onClick={onClose}
            className="px-5 py-2 rounded-xl font-semibold bg-neutral-200 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 hover:bg-neutral-300 transition-colors cursor-pointer"
          >
            Close
          </button>
        </div>

      </div>
    </div>
  );
};
