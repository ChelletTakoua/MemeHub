import React, { useState, useContext } from "react";
import { Link } from "react-router-dom";
import trollFace from "../images/troll_face.png";
import Capture from "../images/Capture.PNG";
import { AppContext } from "../context/AppContext";
import { useNavigate } from "react-router-dom";

const Register = () => {
  const [username, setUsername] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [passwordConfirm, setPasswordConfirm] = useState("");

  const { register, toast } = useContext(AppContext);
  const navigate = useNavigate();

  const handleUsernameChange = (e) => {
    setUsername(e.target.value);
  };

  const handleEmailChange = (e) => {
    setEmail(e.target.value);
  };

  const handlePasswordChange = (e) => {
    setPassword(e.target.value);
  };

  const handlePasswordConfirmChange = (e) => {
    setPasswordConfirm(e.target.value);
  };

  const validateForm = () => {
    if (username === "") {
      toast.error("Username is required.");
      return false;
    } else if (email === "") {
      toast.error("Email is required.");
      return false;
    } else if (password === "") {
      toast.error("Password is required.");
      return false;
    } else if (password.length < 8) {
      toast.error("Password must be at least 8 characters long.");
      return false;
    } else if (passwordConfirm === "") {
      toast.error("Please confirm your password.");
      return false;
    } else if (password !== passwordConfirm) {
      toast.error("Passwords do not match.");
      return false;
    }
    return true;
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    if (validateForm()) {
      // const data = await login(username, password);
      const data = { status: false, msg: "Registration successful." };

      if (data.status === false) {
        toast.error(data.msg);
      } else if (data.status === true) {
        navigate("/");
      } else {
        toast.error("Something went wrong");
      }
    }
  };

  return (
    <section className="bg-palenight">
      <div className="min-h-screen ">
        <div className="flex flex-col items-center justify-center px-6 py-3 mx-auto md:h-screen lg:py-0">
          <Link
            to="/"
            className="flex items-center mb-6 text-2xl font-semibold text-white"
          >
            <img className="w-8 h-8 mr-2" src={trollFace} alt="Troll Face" />
            MemeHub
          </Link>
          <div className="flex flex-col lg:flex-row w-10/12 lg:w-8/12 bg-gray-800 rounded-xl mx-auto shadow-lg overflow-hidden">
            <div className="w-full lg:w-1/2 flex flex-col items-center justify-center p-12 bg-no-repeat bg-cover bg-center">
              <img className="w-full h-full" src={Capture} alt="Spongebob" />
            </div>
            <div className="w-full lg:w-1/2 py-16 px-12">
              <h2 className="text-3xl text-gray-300 mb-4">Register</h2>
              <p className="mb-4 text-gray-300">
                Create your account. It’s free and only take a minute
              </p>
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
                    className=" border sm:text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Username"
                    value={username}
                    onChange={handleUsernameChange}
                  />
                </div>
                <div>
                  <label
                    htmlFor="email"
                    className="block mb-2 text-sm font-medium text-white"
                  >
                    Email
                  </label>
                  <input
                    type="email"
                    name="email"
                    id="email"
                    className=" border  sm:text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 :placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Email address"
                    onChange={handleEmailChange}
                    value={email}
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
                    className=" border sm:text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                    value={password}
                    onChange={handlePasswordChange}
                  />
                </div>
                <div>
                  <label
                    htmlFor="password"
                    className="block mb-2 text-sm font-medium text-white"
                  >
                    Confirm password
                  </label>
                  <input
                    type="password"
                    name="confirm-password"
                    id="confirm-password"
                    placeholder="••••••••"
                    className=" border sm:text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                    value={passwordConfirm}
                    onChange={handlePasswordConfirmChange}
                  />
                </div>
                <div className="mt-5 flex">
                  <input
                    type="checkbox"
                    className="border border-gray-400"
                    required
                  />
                  <span className="text-gray-500 ml-3">
                    I accept the terms of use and privacy policy
                  </span>
                </div>
                <button
                  type="submit"
                  className="w-full text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-primary-600 hover:bg-primary-700 focus:ring-primary-800"
                >
                  Register Now
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Register;
