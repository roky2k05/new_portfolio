import React, { useState } from 'react';
import { 
  Code2, 
  PenTool, 
  Palette, 
  Terminal, 
  Cpu, 
  Layers, 
  CheckCircle2, 
  Sparkles,
  Award,
  BookOpen
} from 'lucide-react';
import { SKILLS_DATA, STATS_DATA } from '../data/portfolioData';

export const SkillsSection: React.FC = () => {
  const [activeTab, setActiveTab] = useState<'All' | 'Development' | 'Design'>('All');

  const filteredSkills = activeTab === 'All' 
    ? SKILLS_DATA 
    : SKILLS_DATA.filter(skill => skill.category === activeTab);

  const getProficiencyBadge = (proficiency: 'Learning' | 'Intermediate' | 'Advanced') => {
    switch (proficiency) {
      case 'Advanced':
        return (
          <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-200/60 dark:border-rose-900/40">
            <span className="w-1.5 h-1.5 rounded-full bg-rose-500" />
            Advanced
          </span>
        );
      case 'Intermediate':
        return (
          <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-sky-50 dark:bg-sky-950/40 text-sky-600 dark:text-sky-400 border border-sky-200/60 dark:border-sky-900/40">
            <span className="w-1.5 h-1.5 rounded-full bg-sky-500" />
            Intermediate
          </span>
        );
      case 'Learning':
        return (
          <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border border-amber-200/60 dark:border-amber-900/40">
            <span className="w-1.5 h-1.5 rounded-full bg-amber-500" />
            Learning
          </span>
        );
    }
  };

  const getSkillIcon = (name: string) => {
    switch (name.toLowerCase()) {
      case 'html5':
      case 'css3':
      case 'javascript':
        return <Code2 className="w-5 h-5 text-rose-500" />;
      case 'php 8+':
        return <Terminal className="w-5 h-5 text-indigo-500" />;
      case 'tailwind css':
        return <Layers className="w-5 h-5 text-cyan-500" />;
      case 'java':
        return <Cpu className="w-5 h-5 text-amber-500" />;
      case 'adobe illustrator':
        return <PenTool className="w-5 h-5 text-amber-500" />;
      case 'adobe photoshop':
        return <Palette className="w-5 h-5 text-blue-500" />;
      default:
        return <Sparkles className="w-5 h-5 text-rose-500" />;
    }
  };

  return (
    <section id="skills" className="py-20 md:py-28 bg-white dark:bg-[#12141c] border-b border-neutral-200/80 dark:border-neutral-800/80 relative">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="flex flex-col items-center text-center max-w-2xl mx-auto mb-16">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-semibold tracking-wider uppercase mb-3 border border-rose-200/60 dark:border-rose-900/40">
            <Cpu className="w-3.5 h-3.5" />
            <span>Technical Capabilities</span>
          </div>
          <h2 className="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
            Skills & Competencies
          </h2>
          <div className="w-12 h-1 bg-rose-500 rounded-full mt-3 mb-4" />
          <p className="text-base text-neutral-600 dark:text-neutral-300">
            Categorized by practical development stack and creative design software with authentic proficiency labels.
          </p>
        </div>

        {/* Category Filter Tabs */}
        <div className="flex justify-center mb-12">
          <div className="inline-flex p-1 rounded-xl bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
            {(['All', 'Development', 'Design'] as const).map((tab) => (
              <button
                key={tab}
                onClick={() => setActiveTab(tab)}
                id={`skills-tab-${tab.toLowerCase()}`}
                className={`px-5 py-2 rounded-lg text-xs font-semibold transition-all duration-200 cursor-pointer ${
                  activeTab === tab
                    ? 'bg-white dark:bg-neutral-800 text-rose-600 dark:text-rose-400 shadow-sm'
                    : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white'
                }`}
              >
                {tab === 'All' ? 'All Skills' : tab === 'Development' ? 'Web Development' : 'Graphic Design'}
              </button>
            ))}
          </div>
        </div>

        {/* Skills Cards Grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-16">
          {filteredSkills.map((skill, idx) => (
            <div
              key={idx}
              id={`skill-card-${skill.name.toLowerCase().replace(/[^a-z0-9]/g, '-')}`}
              className="p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900/70 border border-neutral-200/90 dark:border-neutral-800 hover:border-neutral-300 dark:hover:border-neutral-700 transition-all duration-300 hover:-translate-y-1 hover:shadow-md group flex flex-col justify-between"
            >
              <div>
                <div className="flex items-center justify-between gap-2 mb-3">
                  <div className="w-10 h-10 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 flex items-center justify-center group-hover:scale-105 transition-transform">
                    {getSkillIcon(skill.name)}
                  </div>
                  {getProficiencyBadge(skill.proficiency)}
                </div>

                <h3 className="text-base font-bold font-heading text-neutral-900 dark:text-white mb-1">
                  {skill.name}
                </h3>
                
                <p className="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed">
                  {skill.description}
                </p>
              </div>

              <div className="pt-4 mt-4 border-t border-neutral-200/60 dark:border-neutral-800/60 flex items-center justify-between text-[11px] text-neutral-500 dark:text-neutral-400">
                <span className="font-medium text-neutral-600 dark:text-neutral-400">
                  {skill.category}
                </span>
                <span className="font-code text-rose-500 font-semibold">
                  {skill.proficiency}
                </span>
              </div>
            </div>
          ))}
        </div>

        {/* Animated Counters / Academic & Skill Stats */}
        <div className="rounded-2xl bg-neutral-900 text-white p-8 sm:p-10 border border-neutral-800 shadow-xl">
          <div className="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center divide-y sm:divide-y-0 sm:divide-x divide-neutral-800">
            {STATS_DATA.map((stat, i) => (
              <div key={i} className={`pt-4 sm:pt-0 ${i > 0 ? 'sm:pl-6' : ''}`}>
                <div className="text-3xl sm:text-4xl lg:text-5xl font-extrabold font-heading text-white tracking-tight mb-2 flex items-center justify-center gap-1">
                  <span className="text-rose-500">{stat.value}</span>
                  {stat.suffix && <span className="text-white text-2xl">{stat.suffix}</span>}
                </div>
                <div className="text-sm font-semibold text-neutral-200 mb-1">
                  {stat.label}
                </div>
                <div className="text-xs text-neutral-400">
                  {stat.note}
                </div>
              </div>
            ))}
          </div>
        </div>

      </div>
    </section>
  );
};
