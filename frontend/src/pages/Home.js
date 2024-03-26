import React from "react";
import Card from "../components/Card";
import trollFace from '../images/troll_face.png';
import BackToTop from "../components/BackToTopButton";

const Home = () => {
  return (
      <div className="min-h-screen w-screen bg-palenight">
          <header className="text-center py-20 bg-gradient-to-r from-greens-200 to-palenight shadow-2xl text-white">
              <h1 className="text-5xl mb-5 animate-ping-once ">Welcome to MemeHub!</h1>
              <p className="text-xl animate-pulse ">Enjoy the best memes from around the world</p>
          </header>
          <BackToTop />
          <Card date={"25 March 2024"} user={"Louey Sioua"} profilePic={"https://source.unsplash.com/random/50x50"} meme={"https://source.unsplash.com/random"} index={1} />
          <Card date={"25 March 2024"} user={"Yessine Sellami"} profilePic={"https://source.unsplash.com/random/50x50"} meme={trollFace} index={2}/>
          <Card date={"25 March 2024"} user={"E Tooooooher"} profilePic={"https://source.unsplash.com/random/50x50"} meme={"https://source.unsplash.com/random"} index={3} />
          <Card date={"25 March 2024"} user={"Binomti"} profilePic={"https://source.unsplash.com/random/50x50"} meme={"https://source.unsplash.com/random"} index={4} />
          <Card date={"25 March 2024"} user={"Chidhiiii"} profilePic={"https://source.unsplash.com/random/50x50"} meme={"https://source.unsplash.com/random"} index={5}/>
          <Card date={"25 March 2024"} user={"Takouaa Pres"} profilePic={"https://source.unsplash.com/random/50x50"} meme={"https://source.unsplash.com/random"} index={6} />

          <footer className="p-5 bg-greens-200 text-white text-center">
              <p>© 2023 MemeHub. All rights reserved.</p>
          </footer>
      </div>

  );
};

export default Home;
