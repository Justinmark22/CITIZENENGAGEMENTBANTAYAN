import React, { useState, useEffect } from 'react';
import { createIcons } from 'lucide';

createIcons();

const TypingText = ({ texts, speed = 50, deleteSpeed = 25, pause = 1000 }) => {
  const [textIndex, setTextIndex] = useState(0);
  const [displayText, setDisplayText] = useState('');
  const [charIndex, setCharIndex] = useState(0);
  const [deleting, setDeleting] = useState(false);

  useEffect(() => {
    const current = texts[textIndex];
    if (!deleting && charIndex < current.length) {
      const timeout = setTimeout(() => {
        setDisplayText(prev => prev + current[charIndex]);
        setCharIndex(prev => prev + 1);
      }, speed);
      return () => clearTimeout(timeout);
    } else if (!deleting && charIndex === current.length) {
      const timeout = setTimeout(() => setDeleting(true), pause);
      return () => clearTimeout(timeout);
    } else if (deleting && charIndex > 0) {
      const timeout = setTimeout(() => {
        setDisplayText(prev => prev.slice(0, -1));
        setCharIndex(prev => prev - 1);
      }, deleteSpeed);
      return () => clearTimeout(timeout);
    } else if (deleting && charIndex === 0) {
      setDeleting(false);
      setTextIndex((textIndex + 1) % texts.length);
    }
  }, [charIndex, deleting, textIndex, texts, speed, deleteSpeed, pause]);

  return <>{displayText}</>;
};

const servicesData = {
  leftServices: [
    { title: 'Disaster Response', image: '/images/dis.png', texts: ['MDRRMO: Disaster Preparedness & Emergency Response'] },
    { title: 'Health Services', image: '/images/asd.png', texts: ['Accessible Care for Everyone'] },
    { title: 'Waste Management', image: '/images/waste.png', texts: ['Keeping Bantayan Clean & Safe'] },
    { title: 'Water Management', image: '/images/wat.png', texts: ['Clean Water Access for All'] },
  ],
  rightServices: [
    { title: 'Public Safety', image: '/images/SAN.PNG', texts: ['Protecting Our Communities'] },
    { title: 'Education', image: '/images/as.png', texts: ['Learning & Growth Opportunities'] },
    { title: 'Community Engagement', image: '/images/asdas2.png', texts: ['Bridging Citizens and LGUs'] },
    { title: 'Environmental Care', image: '/images/gsd1.png', texts: ['Preserving Natural Resources'] },
  ]
};

const App = () => {
  const [menuOpen, setMenuOpen] = useState(false);
  const [heroIndex, setHeroIndex] = useState(0);
  const heroImages = [
    '/images/bantayan.png',
    '/images/sta.fe.png',
    '/images/madridejos.png'
  ];

  useEffect(() => {
    const interval = setInterval(() => {
      setHeroIndex((heroIndex + 1) % heroImages.length);
    }, 3000);
    return () => clearInterval(interval);
  }, [heroIndex]);

  return (
    <div className="bg-white text-gray-900 font-roboto">
      {/* Navbar */}
      <nav className="bg-white border-b border-gray-200 shadow-md fixed top-0 inset-x-0 z-50">
        <div className="max-w-7xl mx-auto px-6">
          <div className="flex justify-between items-center h-20">
            <div className="flex items-center gap-3">
              <img src="/images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png" alt="Citizen Logo" className="w-12 h-12 rounded-full shadow-md"/>
              <span className="text-xl md:text-2xl font-extrabold text-black tracking-tight">Bantayan 911</span>
            </div>

            {/* Desktop Menu */}
            <div className="hidden md:flex space-x-8 text-sm font-medium">
              <a href="/" className="hover:text-blue-700 transition">Home</a>
              <a href="/about" className="hover:text-blue-700 transition">About</a>
              <a href="/contact" className="hover:text-blue-700 transition">Contact</a>
              <a href="/faq" className="hover:text-blue-700 transition">FAQs</a>
            </div>

            {/* Desktop Auth */}
            <div className="hidden md:flex items-center gap-3">
              <a href="/login" className="text-sm font-bold text-blue-700 hover:underline">Log In</a>
              <a href="/register" className="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded-lg font-semibold text-sm shadow-md transition">Register</a>
            </div>

            {/* Mobile Menu Button */}
            <div className="md:hidden">
              <button onClick={() => setMenuOpen(!menuOpen)} className="text-gray-800 focus:outline-none">
                {!menuOpen ? (
                  <svg xmlns="http://www.w3.org/2000/svg" className="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16"/>
                  </svg>
                ) : (
                  <svg xmlns="http://www.w3.org/2000/svg" className="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                )}
              </button>
            </div>
          </div>

          {/* Mobile Menu */}
          {menuOpen && (
            <div className="md:hidden bg-white shadow-lg px-6 py-4 space-y-2">
              <a href="/" className="block py-2 hover:text-blue-700">Home</a>
              <a href="/about" className="block py-2 hover:text-blue-700">About</a>
              <a href="/contact" className="block py-2 hover:text-blue-700">Contact</a>
              <a href="/faq" className="block py-2 hover:text-blue-700">FAQs</a>
              <a href="/login" className="block py-2 font-bold text-blue-700">Log In</a>
              <a href="/register" className="block py-2 bg-blue-700 text-white rounded-md text-center mt-2">Register</a>
            </div>
          )}
        </div>
      </nav>

      {/* Hero */}
      <section className="relative pt-32 pb-24 text-white overflow-hidden">
        <div className="absolute inset-0" style={{
          backgroundColor: 'rgba(0,0,0,0.5)',
          backgroundImage: 'url(https://www.toptal.com/designers/subtlepatterns/patterns/lines.png)',
          backgroundRepeat: 'repeat'
        }}></div>
        <div className="absolute inset-0 bg-gradient-to-br from-black/30 via-black/20 to-black/30"></div>

        <div className="relative max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12">
          <div className="lg:w-1/2 text-center lg:text-left animate-fadeInUp">
            <h2 className="text-xl lg:text-2xl font-semibold text-yellow-400 mb-2">Welcome to Bantayan Island</h2>
            <h1 className="text-4xl lg:text-5xl font-extrabold mb-6 leading-tight text-white">
              <TypingText texts={[
                "Strengthening Citizen Engagement Across Communities",
                "Connecting Citizens, LGUs, and Local Communities",
                "Empowering Bantayan, Santa Fe, and Madridejos"
              ]}/>
            </h1>
            <p className="text-lg text-gray-300 mb-8 leading-relaxed">
              Discover a <span className="font-semibold text-yellow-400">transparent digital platform</span> that connects citizens, LGUs, and local communities in Bantayan, Santa Fe, and Madridejos.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
              <a href="#services" className="px-8 py-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 rounded-lg font-bold shadow-md transition">
                Explore Services
              </a>
              <a href="/contact" className="px-8 py-4 bg-white/20 hover:bg-white/30 border border-white rounded-lg font-bold shadow-md transition">
                Contact Us
              </a>
            </div>
          </div>

          <div className="lg:w-1/2 relative rounded-xl overflow-hidden shadow-2xl border border-white/20 h-96">
            {heroImages.map((img, i) => (
              <img key={i} src={img} alt="" className={`absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ${heroIndex === i ? 'opacity-100 z-10' : 'opacity-0 z-0'}`}/>
            ))}
            <div className="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
          </div>
        </div>
      </section>

      {/* Services */}
      <section id="services" className="relative py-24" style={{backgroundColor: 'rgba(144, 238, 144, 0.2)'}}>
        <div className="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16">
          <div className="flex flex-col gap-16">
            {servicesData.leftServices.map((service, i) => (
              <div key={i} className="flex items-center gap-6">
                <div className="w-24 h-24 rounded-full overflow-hidden shadow-2xl flex-shrink-0 transform hover:scale-105 transition-transform duration-500">
                  <img src={service.image} className="w-full h-full object-cover"/>
                </div>
                <div>
                  <h3 className="text-xl font-bold text-gray-900">{service.title}</h3>
                  <p className="text-gray-600 mt-1 text-sm">{service.texts[0]}</p>
                </div>
              </div>
            ))}
          </div>

          <div className="flex flex-col gap-16">
            {servicesData.rightServices.map((service, i) => (
              <div key={i} className="flex items-center gap-6">
                <div className="w-24 h-24 rounded-full overflow-hidden shadow-2xl flex-shrink-0 transform hover:scale-105 transition-transform duration-500">
                  <img src={service.image} className="w-full h-full object-cover"/>
                </div>
                <div>
                  <h3 className="text-xl font-bold text-gray-900">{service.title}</h3>
                  <p className="text-gray-600 mt-1 text-sm">{service.texts[0]}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-gray-900 text-gray-300 mt-16">
        <div className="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-10">
          <div>
            <h4 className="text-white text-lg font-bold mb-4">Quick Links</h4>
            <ul className="space-y-3 text-sm">
              <li><a href="#" className="hover:text-blue-400">Bantayan Updates</a></li>
              <li><a href="#" className="hover:text-blue-400">Santa Fe Updates</a></li>
              <li><a href="#" className="hover:text-blue-400">Madridejos Updates</a></li>
            </ul>
          </div>
          <div>
            <h4 className="text-white text-lg font-bold mb-4">Legal & Policies</h4>
            <ul className="space-y-3 text-sm">
              <li><a href="/privacy-policy" className="hover:text-blue-400">Privacy Policy</a></li>
              <li><a href="/terms-service" className="hover:text-blue-400">Terms of Service</a></li>
            </ul>
          </div>
          <div>
            <h4 className="text-white text-lg font-bold mb-4">Contact</h4>
            <p className="text-gray-400 text-sm">📍 Bantayan Island, Cebu<br/>📧 info@citizenengage.ph<br/>☎ +63 912 345 6789</p>
          </div>
          <div>
            <h4 className="text-white text-lg font-bold mb-4">Stay Connected</h4>
            <div className="flex flex-col space-y-2 text-sm">
              <a href="#" className="hover:text-blue-400">🌐 Facebook</a>
              <a href="#" className="hover:text-blue-400">🐦 Twitter</a>
              <a href="#" className="hover:text-blue-400">📷 Instagram</a>
              <a href="#" className="hover:text-blue-400">▶ YouTube</a>
            </div>
          </div>
        </div>
        <div className="border-t border-gray-700 mt-8">
          <div className="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
            <p>&copy; 2025 Citizen Engagement Bantayan — Connecting People, Building Communities</p>
            <p className="mt-2 md:mt-0">Powered by Local Government & Communities</p>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default App;
