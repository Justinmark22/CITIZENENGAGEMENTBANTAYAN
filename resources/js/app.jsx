import React, { useState, useEffect } from "react";

// Images
import logo from "./images/Gemini_Generated_Image_8a7evl8a7evl8a7e.png";
import bantayanImg from "./images/bantayan.png";
import staFeImg from "./images/sta.fe.png";
import madridejosImg from "./images/madridejos.png";
import disImg from "./images/dis.png";
import healthImg from "./images/asd.png";
import wasteImg from "./images/waste.png";
import waterImg from "./images/wat.png";
import safetyImg from "./images/SAN.PNG";
import eduImg from "./images/as.png";
import communityImg from "./images/asdas (2).png";
import envImg from "./images/gsd (1).png";

// Services & Hero images (same as before)
const servicesData = { /* your leftServices & rightServices */ };
const HeroImages = [bantayanImg, staFeImg, madridejosImg];

const App = () => {
  const [menuOpen, setMenuOpen] = useState(false);
  const [heroIndex, setHeroIndex] = useState(0);

  useEffect(() => {
    const interval = setInterval(() => {
      setHeroIndex((prev) => (prev + 1) % HeroImages.length);
    }, 3000);
    return () => clearInterval(interval);
  }, []);

  return (
    <div>
      {/* your JSX code for Navbar, Hero, Services, Footer */}
    </div>
  );
};

export default App;
