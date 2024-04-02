import trollFace from "../images/troll_face.png";
import React, { useContext, useEffect, useState } from "react";
import { userApi } from "../services/api";
import { Link, useSearchParams } from "react-router-dom";
import { AppContext } from "../context/AppContext";

const VerifyEmail = () => {
  const VerificationStatus = {
    PENDING: 0,
    USER_ALREADY_VERIFIED: 402,
    VERIFIED: 200,
    FAILED_TO_VERIFY: 500,
    TOKEN_EXPIRED: 408,
    INVALID_TOKEN: 403,
  };

  const [searchParams] = useSearchParams();
  const token = searchParams.get("token");

  const [verificationStatus, setVerificationStatus] = useState(0);
  const { toast } = useContext(AppContext);

  useEffect(() => {
    const verifEmail = async () => {
      try {
        await userApi.verifyEmail(token);
        setVerificationStatus(VerificationStatus.VERIFIED);
        toast.success("Your account has been verified successfully.");
      } catch (error) {
        toast.error(error.response?.data.message);
        if (
          error.response?.status === VerificationStatus.USER_ALREADY_VERIFIED
        ) {
          setVerificationStatus(VerificationStatus.USER_ALREADY_VERIFIED);
        } else if (
          error.response?.status === VerificationStatus.TOKEN_EXPIRED
        ) {
          setVerificationStatus(VerificationStatus.TOKEN_EXPIRED);
        } else if (
          error.response?.status === VerificationStatus.INVALID_TOKEN
        ) {
          setVerificationStatus(VerificationStatus.INVALID_TOKEN);
        } else {
          setVerificationStatus(VerificationStatus.FAILED_TO_VERIFY);
        }
      }
    };
    verifEmail();
  }, [
    VerificationStatus.FAILED_TO_VERIFY,
    VerificationStatus.INVALID_TOKEN,
    VerificationStatus.TOKEN_EXPIRED,
    VerificationStatus.USER_ALREADY_VERIFIED,
    VerificationStatus.VERIFIED,
    setVerificationStatus,
    toast,
    token,
  ]);

  return (
    <section className="bg-palenight">
      <div className="flex flex-col items-center space-y-5 justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <Link
          to="/"
          className="flex items-center mb-6 text-xl font-semibold text-white"
        >
          <img className="w-10 h-10 mr-2" src={trollFace} alt="Troll Face" />
          MemeHub
        </Link>

        <div className="w-full rounded-lg shadow border md:mt-0 sm:max-w-xl xl:p-0 bg-gray-800 border-gray-700">
          <div className="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 className="text-xl font-bold leading-tight tracking-tight md:text-5xl text-white">
              Account Verification
            </h1>
            <p className="mb-8 text-gray-300 text-xl ">
              {verificationStatus === VerificationStatus.PENDING &&
                "Your account is being verified. Please wait..."}
              {verificationStatus ===
                VerificationStatus.USER_ALREADY_VERIFIED &&
                "Your account is already verified."}
              {verificationStatus === VerificationStatus.VERIFIED &&
                "Your account has been verified successfully."}
              {verificationStatus === VerificationStatus.FAILED_TO_VERIFY &&
                "Failed to verify your account. Please try again."}
              {verificationStatus === VerificationStatus.TOKEN_EXPIRED &&
                "Verification token has expired. We have sent you another verification email with a new token."}
              {verificationStatus === VerificationStatus.INVALID_TOKEN &&
                "Invalid verification token. Please try again."}
            </p>
            <p className="mb-8">
              Welcome to MemeHub!<br></br> Who came first, the chicken or the
              egg?<br></br> It doesn't matter! It's meming time!{" "}
            </p>
          </div>
        </div>
      </div>
    </section>
  );
};

export default VerifyEmail;
