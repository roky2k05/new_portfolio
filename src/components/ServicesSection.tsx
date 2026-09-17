import React from 'react';
import { 
  Globe, 
  Layout, 
  PenTool, 
  Sparkles, 
  UserCheck, 
  Rocket, 
  ArrowRight, 
  Check,
  Briefcase
} from 'lucide-react';
import { SERVICES_DATA } from '../data/portfolioData';

interface ServicesSectionProps {
  onSelectService: (serviceTitle: string) => void;
}

export const ServicesSection: React.FC<ServicesSectionProps> = ({ onSelectService }) => {
  const getIcon = (iconName: string) => {
    switch (iconName) {
      case 'globe':
        return <Globe className="w-6 h-6 text-rose-500" />;
      case 'layout':
        return <Layout className="w-6 h-6 text-sky-500" />;
      case 'pen-tool':
        return <PenTool className="w-6 h-6 text-amber-500" />;
      case 'sparkles':
        return <Sparkles className="w-6 h-6 text-purple-500" />;
      case 'user-check':
        return <UserCheck className="w-6 h-6 text-emerald-500" />;
      case 'rocket':
        return <Rocket className="w-6 h-6 text-rose-500" />;
      default:
        return <Briefcase className="w-6 h-6 text-rose-500" />;
    }
  };

  return (
    <section id="services" className="py-20 md:py-28 bg-neutral-50 dark:bg-[#0e1015] border-b border-neutral-200/80 dark:border-neutral-800/80 relative">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="flex flex-col items-center text-center max-w-2xl mx-auto mb-16">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-semibold tracking-wider uppercase mb-3 border border-rose-200/60 dark:border-rose-900/40">
            <Briefcase className="w-3.5 h-3.5" />
            <span>Professional Solutions</span>
          </div>
          <h2 className="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
            Services & Expertise
          </h2>
          <div className="w-12 h-1 bg-rose-500 rounded-full mt-3 mb-4" />
          <p className="text-base text-neutral-600 dark:text-neutral-300">
            End-to-end web engineering and creative design services tailored to launch and elevate modern brands.
          </p>
        </div>

        {/* 6 Services Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
          {SERVICES_DATA.map((service) => (
            <div
              key={service.id}
              id={`service-card-${service.number}`}
              className="p-7 rounded-2xl bg-white dark:bg-neutral-900/80 border border-neutral-200/90 dark:border-neutral-800 hover:border-neutral-300 dark:hover:border-neutral-700 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg flex flex-col justify-between group"
            >
              <div>
                {/* Number & Icon */}
                <div className="flex items-center justify-between mb-6">
                  <span className="text-2xl font-extrabold font-heading text-neutral-300 dark:text-neutral-700 group-hover:text-rose-500 transition-colors">
                    {service.number}
                  </span>
                  <div className="w-12 h-12 rounded-xl bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 flex items-center justify-center group-hover:scale-105 transition-transform">
                    {getIcon(service.icon)}
                  </div>
                </div>

                {/* Title */}
                <h3 className="text-xl font-bold font-heading text-neutral-900 dark:text-white mb-2.5">
                  {service.title}
                </h3>

                {/* Description */}
                <p className="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed mb-6">
                  {service.description}
                </p>

                {/* Deliverables List */}
                <div className="space-y-2 mb-6 pt-4 border-t border-neutral-100 dark:border-neutral-800">
                  {service.deliverables.map((item, idx) => (
                    <div key={idx} className="flex items-start gap-2 text-xs text-neutral-600 dark:text-neutral-400">
                      <Check className="w-3.5 h-3.5 text-emerald-500 shrink-0 mt-0.5" />
                      <span>{item}</span>
                    </div>
                  ))}
                </div>
              </div>

              {/* Action Button */}
              <button
                onClick={() => onSelectService(service.title)}
                id={`service-btn-${service.number}`}
                className="w-full inline-flex items-center justify-between px-4 py-2.5 rounded-xl text-xs font-semibold text-neutral-700 dark:text-neutral-300 bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-800 dark:hover:bg-neutral-700 transition-colors cursor-pointer group/btn"
              >
                <span>Request {service.title}</span>
                <ArrowRight className="w-3.5 h-3.5 text-rose-500 group-hover/btn:translate-x-1 transition-transform" />
              </button>
            </div>
          ))}
        </div>

      </div>
    </section>
  );
};
