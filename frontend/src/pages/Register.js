import React, { useState, useContext } from "react";
import register_meme from "../images/register_meme.jpg";
import { AppContext } from "../context/AppContext";
import { Link } from "react-router-dom";

const Register = () => {
  const [username, setUsername] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [passwordConfirm, setPasswordConfirm] = useState("");

  const { register, toast } = useContext(AppContext);

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
    } else if (password.length < 6) {
      toast.error("Password must be at least 6 characters long.");
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
      await register(username, email, password);
    }
  };

  return (
    <section className="flex items-center justify-center grow bg-palenight">
      <div className="flex items-center justify-center w-10/12 bg-gray-800 rounded-xl shadow overflow-hidden">
        <div className="w-1/2 flex flex-col items-center justify-center p-8 bg-no-repeat bg-cover bg-center">
          <img
            className="rounded-xl w-11/12 object-cover"
            src={register_meme}
            alt="Welcome"
          />
        </div>
        <div className="w-1/2 px-6">
          <h2 className="text-3xl text-gray-300 mb-4">Register</h2>
          <p className="mb-4 text-gray-300">
            Create your account. It’s free and only take a minute
          </p>
          <form
            className="space-y-4 md:space-y-6"
            action="#"
            onSubmit={handleSubmit}
          >
            <div className="flex justify-between gap-4">
              <div className="w-full flex flex-col gap-4">
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
              </div>
              <div className="w-full flex flex-col gap-4">
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
              </div>
            </div>
            <div className="mt-5 flex">
              <input
                  type="checkbox"
                  className="border border-gray-400"
                  required
              />
              <p className="text-lg font-light text-gray-400 p-2">
                I accept the
                <Link to="/termsofuse"
                      className="hover:underline text-primary-400 hover:text-primary-500 transition-colors duration-200">
                  <span className="font-medium">  terms of use and privacy policy</span>
                <i className="fas fa-link ml-2"></i>
                </Link>
              </p>
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
    </section>
  );
};

export default Register;
