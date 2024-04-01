import React, { useContext, useEffect, useRef, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import Moment from "react-moment";
import ProfileCard from "../components/ProfileCard";
import { AppContext } from "../context/AppContext";
import { memeApi, userApi } from "../services/api";

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
  }, [setEmail, setUsername, setProfileImage, setRegDate, isOwner, id, user]);

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
    <div className="bg-palenight">
      <main className="container mx-auto py-8">
        <div className="flex space-x-8">
          <div className="w-1/4">
            <input
              type="file"
              onChange={handleImageUpload}
              disabled={!isOwner}
              className={`${isOwner ? "" : "hidden"} mb-4`}
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
            <p className="text-gray-300">
              Joined: <Moment fromNow>{new Date(regDate)}</Moment>
            </p>
            <p className="text-gray-300">
              Total Memes Contributed: {memes ? memes.length : 0}
            </p>
            <div className="mt-4">
              <h3 className="text-xl font-bold text-white">
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
            </div>
            {isOwner && (
              <button
                onClick={handleSave}
                type="submit"
                className="px-4 py-2 ml-10 mt-20 text-white bg-blue-800 rounded shadow-lg active:text-gray-500"
              >
                Save Changes
              </button>
            )}
          </div>
          <div className="w-3/4">
            <div className="w-3/4">
              <h3 className="text-xl font-bold mt-4 text-white">My Memes</h3>
              <div className="grid grid-cols-3 gap-4 mt-2">
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
