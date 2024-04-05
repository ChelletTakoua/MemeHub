import React, { useContext, useEffect, useRef, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import Moment from "react-moment";
import ProfileCard from "../components/ProfileCard";
import { AppContext } from "../context/AppContext";
import { memeApi, userApi } from "../services/api";
import { Link } from "react-router-dom";
import { FaPlusCircle } from "react-icons/fa";

const Profile = () => {
  const { user, setUser, toast } = useContext(AppContext);

  const { id } = useParams("id");
  const isOwner = user?.id === +id;

  const [username, setUsername] = useState("");
  const [email, setEmail] = useState("");
  const [profileImage, setProfileImage] = useState(null);
  const [regDate, setRegDate] = useState("");
  const [memes, setMemes] = useState([]);

  const usernameChanged = useRef(false);
  const emailChanged = useRef(false);
  const profileImageChanged = useRef(false);

  const navigate = useNavigate();

  useEffect(() => {
    const fetchUser = async (id) => {
      try {
        const res = await userApi.getUserProfile(id);
        setUsername(res?.data.data.user.username);
        setEmail(res?.data.data.user.email);
        setProfileImage(res?.data.data.user.profile_pic);
        setRegDate(res?.data.data.user.reg_dat);
      } catch (error) {
        navigate("/not_found");
      }
    };

    const fetchMemes = async (id) => {
      try {
        const res = await memeApi.getUserMemes(id);
        setMemes(res?.data.data.memes);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    };

    if (isOwner) {
      setEmail(user?.email);
      setUsername(user?.username);
      setProfileImage(user?.profile_pic);
      setRegDate(user?.reg_dat);
    } else {
      fetchUser(id);
    }
    fetchMemes(id);
  }, [
    setEmail,
    setUsername,
    setProfileImage,
    setRegDate,
    navigate,
    isOwner,
    id,
    user,
  ]);

  const handleImageUpload = (event) => {
    if (isOwner) {
      const reader = new FileReader();
      reader.onload = () => {
        const base64Image = reader.result.split(",")[1];
        setProfileImage(base64Image);
      };
      reader.readAsDataURL(event.target.files[0]);
      profileImageChanged.current = true;
    }
  };

  const handleUsernameChange = (e) => {
    if (isOwner) {
      setUsername(e.target.value);
      usernameChanged.current = true;
    }
  };

  const handleEmailChange = (e) => {
    if (isOwner) {
      setEmail(e.target.value);
      emailChanged.current = true;
    }
  };

  const handleSave = () => {
    if (
      usernameChanged.current ||
      emailChanged.current ||
      profileImageChanged.current
    ) {
      const updatedData = {};
      if (usernameChanged.current) {
        updatedData.username = username;
      }
      if (emailChanged.current) {
        updatedData.email = email;
      }
      if (profileImageChanged.current) {
        updatedData.profile_pic = profileImage;
      }
      try {
        userApi.editUserProfile(updatedData);
        toast.success("Profile updated successfully.");
        setUser({ ...user, ...updatedData });
      } catch (error) {
        console.error("Error updating profile:", error);
        toast.error("Error updating profile.");
      }
    }
  };

  return (
    <div className="grow bg-palenight">
      <main className="container mx-auto py-8">
        <div className="flex space-x-8">
          <div className="w-1/4 h-full bg-white bg-opacity-5 rounded-lg shadow-2xl px-4 py-8 flex flex-col items-center">
            <input
              type="file"
              accept="image/*"
              onChange={handleImageUpload}
              disabled={!isOwner}
              className={`${
                isOwner ? "" : "hidden"
              } mb-4 w-full px-3 py-2 text-white bg-gray-800 rounded shadow-lg 
                        active:text-gray-500 cursor-pointer hover:bg-gray-700 hover:text-gray-200 hover:shadow-md hover:active:bg-gray-800 hover:active:text-white hover:active:shadow-lg hover:active:cursor-pointer hover:active:transition-all`}
            />
            <img
              src={`data:image/jpeg;base64,${profileImage}`}
              alt="Profile"
              className="rounded-full w-32 h-32 mx-auto shadow-lg"
            />
            {isOwner ? (
              <input
                value={username}
                onChange={handleUsernameChange}
                className="w-full px-3 py-2 mt-4 text-white bg-gray-800 rounded shadow-lg"
              />
            ) : (
              <h2 className="text-2xl font-bold mt-4 text-white">{username}</h2>
            )}
            <p className="text-gray-300 mt-4">
              Joined: <Moment fromNow>{new Date(regDate)}</Moment>
            </p>
            <p className="text-gray-300">
              Total Memes Contributed: {memes ? memes.length : 0}
            </p>
            <h3 className="text-xl font-bold text-white mt-6">
              Contact Information
            </h3>
            {isOwner ? (
              <input
                type="email"
                value={email}
                onChange={handleEmailChange}
                className="w-full px-3 py-2 mt-4 text-white bg-gray-800 rounded shadow-lg"
              />
            ) : (
              <p className="text-gray-300">Email: {email}</p>
            )}
            {isOwner && (
              <button
                onClick={handleSave}
                type="submit"
                className="px-4 py-2 mt-6 text-white bg-blue-800 rounded shadow-lg active:text-gray-500"
              >
                Save Changes
              </button>
            )}
          </div>
          <div className="w-3/4 flex justify-center">
            <div className="w-11/12">
              <h2 className="text-2xl font-bold mb-8 text-white">My Memes</h2>
              <div className="grid grid-cols-3 gap-6 mt-2">
                {memes.length === 0 && ( // If there are no memes //TODO: make this better
                  <div className="flex flex-col items-center justify-center gap-4">
                    <div className="text-black">No memes to show.</div>
                    <Link to="/create">
                      <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <span className="flex gap-2 items-center">
                          <FaPlusCircle />
                          Add a Meme
                        </span>
                      </button>
                    </Link>
                  </div>
                )}
                {memes?.map((meme) => (
                  <ProfileCard
                    key={meme.id}
                    isOwner={isOwner}
                    meme={meme}
                    memes={memes}
                    setMemes={setMemes}
                  />
                ))}
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  );
};

export default Profile;
