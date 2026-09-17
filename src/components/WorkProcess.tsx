import React from 'react';
import { 
  CheckCircle, 
  Workflow, 
  Search, 
  PenTool, 
  Palette, 
  Code, 
  CheckCheck, 
  PackageCheck,
  ArrowRight
} from 'lucide-react';
import { PROCESS_STEPS } from '../data/portfolioData';

export const WorkProcess: React.FC = () => {
  const getStepIcon = (step: string) => {
    switch (step) {
      case '01':
        return <Search className="w-5 h-5 text-rose-500" />;
      case '02':
        return <PenTool className="w-5 h-5 text-amber-500" />;
      case '03':
        return <Palette className="w-5 h-5 text-sky-500" />;
      case '04':
        return <Code className="w-5 h-5 text-emerald-500" />;
      case '05':
        return <CheckCheck className="w-5 h-5 text-purple-500" />;
      case '06':
        return <PackageCheck className="w-5 h-5 text-rose-500" />;
      default:
        return <Workflow className="w-5 h-5 text-rose-500" />;
    }
  };

  return (
    <section id="how-i-work" className="py-20 md:py-28 bg-white dark:bg-[#12141c] border-b border-neutral-200/80 dark:border-neutral-800/80 relative">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="flex flex-col items-center text-center max-w-2xl mx-auto mb-16">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-semibold tracking-wider uppercase mb-3 border border-rose-200/60 dark:border-rose-900/40">
            <Workflow className="w-3.5 h-3.5" />
            <span>Structured Methodology</span>
          </div>
          <h2 className="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
            How I Work & Deliver
          </h2>
          <div className="w-12 h-1 bg-rose-500 rounded-full mt-3 mb-4" />
          <p className="text-base text-neutral-600 dark:text-neutral-300">
            A transparent 6-stage development and design process ensuring high quality, precision, and reliable delivery.
          </p>
        </div>

        {/* Process Timeline: Horizontal on Desktop (Grid with connectors) / Vertical on Mobile */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative">
          {PROCESS_STEPS.map((step, idx) => (
            <div
              key={step.step}
              id={`process-step-${step.step}`}
              className="p-6 rounded-2xl bg-neutral-50 dark:bg-neutral-900/70 border border-neutral-200/90 dark:border-neutral-800 hover:border-neutral-300 dark:hover:border-neutral-700 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden"
            >
              {/* Background Step Watermark */}
              <span className="absolute -right-2 -bottom-4 text-7xl font-black font-heading text-neutral-200/50 dark:text-neutral-800/40 pointer-events-none select-none group-hover:text-rose-500/10 transition-colors">
                {step.step}
              </span>

              <div>
                {/* Header Node */}
                <div className="flex items-center justify-between mb-4">
                  <div className="w-10 h-10 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 flex items-center justify-center shadow-xs">
                    {getStepIcon(step.step)}
                  </div>
                  <span className="px-2.5 py-1 rounded-full text-xs font-bold font-code bg-neutral-200/70 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200">
                    Stage {step.step}
                  </span>
                </div>

                {/* Title */}
                <h3 className="text-lg font-bold font-heading text-neutral-900 dark:text-white mb-2">
                  {step.title}
                </h3>

                {/* Description */}
                <p className="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed mb-4">
                  {step.description}
                </p>
              </div>

              {/* Output / Deliverable Badge */}
              <div className="pt-3 border-t border-neutral-200/80 dark:border-neutral-800 flex items-center gap-2 text-xs text-neutral-600 dark:text-neutral-400 font-medium">
                <span className="text-rose-500 font-bold">Deliverable:</span>
                <span className="truncate">{step.deliverable}</span>
              </div>
            </div>
          ))}
        </div>

      </div>
    </section>
  );
};
