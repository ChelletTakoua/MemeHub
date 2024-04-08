import React, { useContext, useState } from "react";
import { AppContext } from "../context/AppContext";
import { userApi } from "../services/api";

const ForgotPassword = () => {
  const [username, setUsername] = useState("");
  const { toast } = useContext(AppContext);

  const handleUsernameChange = (e) => {
    setUsername(e.target.value);
  };

  const handleResetPassword = async (e) => {
    e.preventDefault();
    if (username === "") return toast.error("Please enter your username");
    try {
      const reponse = await userApi.forgotPassword(username);
      toast.success("Password reset link sent to your email: " + reponse.data.data.email);
    } catch (error) {
      toast.error(error.response.data.message);
    }
  };
  return (
    <div className="grow flex justify-center items-center bg-palenight text-white">
      <div className="bg-gray-800 shadow-md rounded-lg px-24 pt-8 pb-8 my-2 mx-8 w-1/2">
        <h1 className="mb-6 font-bold text-4xl ">Reset Password</h1>
        <form className="mb-4" onSubmit={handleResetPassword}>
          <div className="mb-6">
            <label
              className="block text-gray-300 text-sm font-bold mb-2"
              htmlFor="username"
            >
              Username
            </label>
            <input
              className="shadow appearance-none border rounded w-full py-3 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline"
              id="username"
              type="text"
              placeholder="Enter your username"
              onChange={handleUsernameChange}
            />
          </div>
          <div className="flex items-center justify-center">
            <button
              className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded focus:outline-none focus:shadow-outline"
              type="submit"
              onClick={handleResetPassword}
            >
              Reset Password
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default ForgotPassword;
