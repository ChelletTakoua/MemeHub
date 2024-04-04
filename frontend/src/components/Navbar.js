import trollFace from "../images/troll_face.png";
import { Link } from "react-router-dom";
import { useContext } from "react";
import { AppContext } from "../context/AppContext";
import {
  FaHome,
  FaInfo,
  FaPlusCircle,
  FaSignOutAlt,
  FaUser,
} from "react-icons/fa";

export default function Navbar() {
  const { user, logout } = useContext(AppContext);

  return (
    <nav className="flex items-center justify-between py-4 px-8 bg-white bg-gradient-to-r from-algae to-grass shadow-2xl md:h-40 lg:h-28 lg:px-28 ">
      <Link to="/" className="flex items-center gap-4">
        <img src={trollFace} alt="Troll Face" className="w-12 h-12" />
        <h1 className="text-2xl font-bold text-white">MemeHub</h1>
      </Link>
      <ul className="flex gap-12 items-center">
        <li className="">
          <Link
            className="flex items-center gap-2 bg-black bg-opacity-10 text-white hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-bold rounded-lg text-md px-5 py-2.5 text-center"
            to="/"
          >
            <FaHome />
            <span>Home</span>
          </Link>
        </li>
        <li className="">
          <Link
            className="flex items-center gap-2 bg-black bg-opacity-10 text-white hover:text-white border border-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-bold rounded-lg text-md px-5 py-2.5 text-center"
            to="/about"
          >
            <FaInfo className="" />
            <span>About us</span>
          </Link>
        </li>
      </ul>
      <div className="flex gap-4">
        {user ? (
          <>
            <Link reloadDocument to="/create">
              <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <span className="flex gap-2 items-center">
                  <FaPlusCircle />
                  Add a Meme
                </span>
              </button>
            </Link>
            <Link to={`/profile/${user.id}`}>
              <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <span className="flex gap-2 items-center">
                  <FaUser />
                  My Profile
                </span>
              </button>
            </Link>
            <Link
              to="/"
              onClick={async () => {
                await logout();
              }}
            >
              <button className="h-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                <span className="flex gap-2 items-center">
                  <FaSignOutAlt />
                </span>
              </button>
            </Link>
          </>
        ) : (
          <>
            <Link to="/login">
              <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Sign in
              </button>
            </Link>
            <Link to="/register">
              <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Register
              </button>
            </Link>
          </>
        )}
      </div>
    </nav>
  );
}
