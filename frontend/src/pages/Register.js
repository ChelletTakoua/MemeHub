import React, { useState } from "react";
import { Link } from "react-router-dom";
import trollFace from "../images/troll_face.png";
import Capture from '../pages/images/Capture.PNG';

const Register = () => {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");

  const handleUsernameChange = (e) => {
    setUsername(e.target.value);
  };

  const handlePasswordChange = (e) => {
    setPassword(e.target.value);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    // Add your registration logic here
  };

  return (
    <section class="dark:bg-palenight min-h-screen w-screen">
      <div class="min-h-screen ">
          <div class="flex flex-col items-center justify-center px-6 py-3 mx-auto md:h-screen lg:py-0">
              <Link   to="/" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white"  >
                  <img class="w-8 h-8 mr-2" img src={trollFace} alt="Troll Face" />
                  MemeHub
              </Link>
              <div class="flex flex-col lg:flex-row w-10/12 lg:w-8/12 bg-white rounded-xl mx-auto shadow-lg overflow-hidden">
                <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-12 bg-no-repeat bg-cover bg-center">
                  <img className="w-full h-full" src={Capture} alt="Spongebob" />
                </div>
                <div class="w-full lg:w-1/2 py-16 px-12">
                  <h2  class="text-3xl mb-4">Register</h2>
                  <p class="mb-4">
                    Create your account. It’s free and only take a minute
                  </p>
                  <form
                        class="space-y-4 md:space-y-6"
                        action="#"
                        onSubmit={handleSubmit}
                      >
                        <div>
                          <label
                            for="username"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                          >
                            Username
                          </label>
                          <input
                            type="text"
                            name="username"
                            id="username"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Username"
                            required=""
                            value={username}
                            onChange={handleUsernameChange}
                          />
                        </div>
                        <div>
                          <label
                            for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                          >
                            Email
                          </label>
                          <input
                            type="email"
                            name="email"
                            id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Email address"
                            required=""
                          />
                        </div>
                        <div>
                          <label
                            for="password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                          >
                            Password
                          </label>
                          <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required=""
                            value={password}
                            onChange={handlePasswordChange}
                          /> 
                        </div>
                        <div>
                          <label
                            for="password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                          >
                            Confirm password
                          </label>
                          <input
                            type="password"
                            name="confirm-password"
                            id="confirm-password"
                            placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required=""
                          /> 
                        </div>
                        <div class="mt-5">
                          <input type="checkbox" class="border border-gray-400" required/>
                          <span>
                              I accept the terms of use and privacy policy
                          </span>
                        </div>
                        <button
                          type="submit"
                          class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                        >Register Now</button>
                      </form>
                </div>
              </div>
            </div>
          </div>
        </section>
  );
};

export default Register;

