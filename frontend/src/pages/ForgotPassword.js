/*import trollFace from "../images/troll_face.png";
import React, { useContext, useState } from "react";
import { Link } from "react-router-dom";
import { AppContext } from "../context/AppContext";

const Login = () => {
  const [username, setUsername] = useState("");

  const { login, toast } = useContext(AppContext);

  const handleUsernameChange = (e) => {
    setUsername(e.target.value);
  };

  const validateForm = () => {
    if (username === "") {
      toast.error("Username is required.");
      return false;
    } return true;
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    if (validateForm()) {
      await login(username, password);
    }
  };

  return (
    <section className="bg-palenight">
      <div className="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <Link
          to="/"
          className="flex items-center mb-6 text-2xl font-semibold text-white"
        >
          <img className="w-8 h-8 mr-2" src={trollFace} alt="Troll Face" />
          MemeHub
        </Link>
        <div className="w-full rounded-lg shadow border md:mt-0 sm:max-w-md xl:p-0 bg-gray-800 border-gray-700">
          <div className="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 className="text-xl font-bold leading-tight tracking-tight md:text-2xl text-white">
              Sign in to your account
            </h1>
            <form
              className="space-y-4 md:space-y-6"
              action="#"
              onSubmit={handleSubmit}
            >
              <div>
                <label
                  htmlFor="username"
                  className="block mb-2 text-sm font-medium text-white"
                >
                  Username
                </label>
                <input
                  type="text"
                  name="username"
                  id="username"
                  className="border sm:text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Username"
                  value={username}
                  onChange={handleUsernameChange}
                />
              </div>
              <div>
                <label
                  htmlFor="password"
                  className="block mb-2 text-sm font-medium text-white"
                >
                  Password
                </label>
                <input
                  type="password"
                  name="password"
                  id="password"
                  placeholder="••••••••"
                  className=" border  sm:text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                  value={password}
                  onChange={handlePasswordChange}
                />
              </div>

              <button
                type="submit"
                className="w-full text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-primary-600 hover:bg-primary-700 focus:ring-primary-800"
              >
                Sign in
              </button>
              <p className="text-sm font-light text-gray-400">
                Don't have an account yet?
                <Link
                  to="/register"
                  className="hover:underline text-primary-400"
                >
                  <span className="font-medium"> Sign up here</span>
                </Link>
              </p>
              <p>
                <Link
                  to="/forgotPassword"
                  className="hover:underline text-primary-400"
                >
                  <span className="font-medium">Forgot your password?</span>
                </Link>

              </p>
            </form>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Login;
*/