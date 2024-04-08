import React, { useContext, useEffect, useState } from "react";
import { AppContext } from "../context/AppContext";
import { userApi } from "../services/api";
import { useNavigate, useSearchParams } from "react-router-dom";

const ResetPassword = () => {
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const { toast } = useContext(AppContext);
  const [searchParams] = useSearchParams();
  const token = searchParams.get("token");
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    const verifyToken = async () => {
      try {
        setLoading(true);
        await userApi.verifyToken(token);
      } catch (error) {
        setError(error.response.data.message);
      } finally {
        setLoading(false);
      }
    };
    verifyToken();
    if (error) {
      setTimeout(() => {
        navigate("/");
      }, 1500);
    }
  }, [searchParams, token, toast, navigate, error]);

  const handleResetPassword = async (e) => {
    e.preventDefault();
    if (password === "" || confirmPassword === "") {
      return toast.error("Please enter both passwords");
    }
    if (password !== confirmPassword) {
      return toast.error("Passwords do not match");
    }
    if(password.length < 6) {
      return toast.error("Password must be at least 6 characters long");
    }
    try {
      await userApi.resetPassword(token, password);
      toast.success("Password reset successfully");
      setTimeout(() => {
        navigate("/");
      }, 1500);
    } catch (error) {
      toast.error(error.response.data.message);
    }
  };

  return (
    <div className="grow flex justify-center items-center bg-palenight text-white">
      <div className="bg-gray-800 shadow-md rounded-lg px-24 pt-8 pb-8 my-2 mx-8 w-1/2">
        <h1 className="mb-6 font-bold text-4xl ">Reset Password</h1>
        {loading ? (
          <div className="flex justify-center items-center">
            <div className="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-32 w-32"></div>
          </div>
        ) : error ? (
          <div className="text-red-500 text-center">{error}</div>
        ) : (
          <form className="mb-4" onSubmit={handleResetPassword}>
            <div className="mb-6">
              <label
                className="block text-gray-300 text-sm font-bold mb-2"
                htmlFor="password"
              >
                Password
              </label>
              <input
                className="shadow appearance-none border rounded w-full py-3 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline"
                id="password"
                type="password"
                placeholder="Enter your new password"
                onChange={(e) => setPassword(e.target.value)}
              />
            </div>
            <div className="mb-6">
              <label
                className="block text-gray-300 text-sm font-bold mb-2"
                htmlFor="confirmPassword"
              >
                Confirm Password
              </label>
              <input
                className="shadow appearance-none border rounded w-full py-3 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline"
                id="confirmPassword"
                type="password"
                placeholder="Re-enter your new password"
                onChange={(e) => setConfirmPassword(e.target.value)}
              />
            </div>
            <div className="flex items-center justify-center">
              <button
                className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded focus:outline-none focus:shadow-outline"
                type="submit"
              >
                Reset Password
              </button>
            </div>
          </form>
        )}
      </div>
    </div>
  );
};

export default ResetPassword;
