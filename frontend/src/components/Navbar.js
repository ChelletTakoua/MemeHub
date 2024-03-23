import trollFace from "../images/troll_face.png";
import { Link } from "react-router-dom";

export default function Navbar() {
  return (
    <nav className="flex items-center justify-between py-4 px-8 bg-white bg-gradient-to-r from-algae to-grass shadow-2xl md:h-40 lg:h-28 lg:px-44 ">
      <div className="flex items-center gap-4">
        <img src={trollFace} alt="Troll Face" className="w-12 h-12" />
        <h1 className="text-2xl font-bold text-white">MemeHub</h1>
      </div>
      <ul className="flex gap-24 ">
        <li className="py-2 px-3">
          <Link to="/">Home</Link>
        </li>
        <li className="py-2 px-3">
          <Link to="/about">About</Link>
        </li>
        <li className="py-2 px-3">
          <Link to="/contact">Contact</Link>
        </li>
      </ul>
      <div>
        <Link to="/login">
          <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Sign in
          </button>
        </Link>
      </div>
    </nav>
  );
}
