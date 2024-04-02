import React from "react";

const ResetPassword = () => {
  return (
    <div className="bg-palenight min-h-screen flex flex-col items-center justify-center text-white">
      <div className="bg-gray-800 shadow-md rounded-lg px-12 pt-8 pb-8 my-2 mx-8">
        <div className="px-12 py-6 mb-6">
          <p className="text-lg font-semibold">
            Forgot your password? Reset it from here
          </p>
        </div>
      </div>
      <div className="bg-gray-800 shadow-md rounded-lg px-12 pt-8 pb-8 my-2 mx-8">
        <h1 className="mb-6 font-bold text-4xl text-center">Reset Password</h1>
        <form className="mb-4">
          <div className="mb-6">
            <label
              className="block text-gray-300 text-sm font-bold mb-2"
              htmlFor="email"
            >
              Email
            </label>
            <input
              className="shadow appearance-none border rounded w-full py-3 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline"
              id="email"
              type="email"
              placeholder="Enter your email"
            />
          </div>
          <div className="flex items-center justify-center">
            <button
              className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded focus:outline-none focus:shadow-outline"
              type="button"
            >
              Reset Password
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default ResetPassword;
