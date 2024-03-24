import React, { useState } from "react";

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
    <div className="min-h-screen py-40" style={{ backgroundImage: 'linear-gradient(115deg, #166534, #bbf7d0)' }}>
      <div class="container mx-auto">
          <div class=" flex flex-col lg:flex-row w-8/12 bg-white rounded-xl mx-auto shadow-lg overflow:hidden">
            <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-12 bg-no-repeat bg-cover bg-center" style={{backgroundImage: "url('https://i.kym-cdn.com/entries/icons/facebook/000/006/428/637738.jpg')" }}>
                <h1 class="text-white text-3xl mb-3">Welcome to MemeHub</h1>
                <p class="text-white">
                    A meme generator and sharing platform where users can create and share memes. Users can react to and comment on posts, making it a fun and interactive community for meme lovers.
                </p>
            </div>
            <div class="w-full lg:w-1/2 py=16 px=12">
                <h2 class="text-3xl mb-4">Register</h2>
                <p class="mb-4">create an account and join the fun .</p>
                <form onSubmit={handleSubmit}>
                    <div class="grid grid-cols-2 gap-5">
                        <input type="text" placeholder="First name" class="border border-gray-400 py-1 px-2" value={username} onChange={handleUsernameChange}/>
                        <input type="text" placeholder="Surname" class="border border-gray-400 py-1 px-2"/>
                    </div>
                    <div class="mt-5">
                        <input type="text" placeholder="Email" class="border border-gray-400 py-1 px-2 w-full"/>
                    </div>
                    <div class="mt-5">
                        <input type="password" placeholder="Password" class="border border-gray-400 py-1 px-2 w-full"/>
                    </div>
                    <div class="mt-5">
                        <input type="password" placeholder="Confirm password" class="border border-gray-400 py-1 px-2 w-full" value={password} onChange={handlePasswordChange}/>
                    </div>
                    <div class="mt-5">
                        <input type="checkbox" class="border border-gray-400" required/>
                        <span>
                            I accept the terms of use and privacy policy
                        </span>
                    </div>
                    <div class="mt-5">
                        <button class="w-full bg-green-500 py-3 text-center text-white">Register Now</button>
                    </div>
                </form>
            </div>
          </div>
      </div>
    </div>
  );
};

export default Register;

