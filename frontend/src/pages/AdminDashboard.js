import React, { useCallback, useContext, useEffect, useState } from "react";
import { AppContext } from "../context/AppContext";
import { adminApi, memeApi } from "../services/api";
import { Modal } from "react-responsive-modal";
import "react-responsive-modal/styles.css";

const AdminDashboard = () => {
  const [selectedButton, setSelectedButton] = useState("Pending");
  const [admins, setAdmins] = useState([]);
  const [reports, setReports] = useState([]);
  const [stats, setStats] = useState({});
  const [viewedImg, setViewedImg] = useState("");
  const [openView, setOpenView] = useState(false);
  const [debugBtnVisible, setDebugBtnVisible] = useState(false);

  const { toast } = useContext(AppContext);

  const fetchReports = useCallback(async () => {
    try {
      const res = await adminApi.getAllReports();
      setReports(res.data.data.reports);
    } catch (error) {
      console.error("Error fetching data:", error);
      toast.error("Failed to fetch reports");
    }
  }, [toast]);

  useEffect(() => {
    const fetchAdminsAndStats = async () => {
      try {
        const res = await adminApi.getAllUsers();
        // Update the totalUsers stat
        setStats((prev) => {
          return {
            ...prev,
            totalUsers: res.data.data.users.length,
          };
        });
        // Update the admins list
        setAdmins(res.data.data.users.filter((user) => user.role === "admin"));

        // Fetch the total memes
        const resMemes = await memeApi.getAllMemes();
        setStats((prev) => {
          return {
            ...prev,
            totalMemes: resMemes.data.data.memes.length,
          };
        });
      } catch (error) {
        console.error("Error fetching data:", error);
        toast.error("Failed to fetch admins and stats");
      }
    };
    const fetchDebugModeStatus = async () => {
      try {
        const res = await adminApi.getDebugModeStatus();
        setDebugBtnVisible(res.status === 200);
      } catch (error) {
        console.error("Error fetching data:", error);
        toast.error("Failed to fetch debug mode status");
      }
    };
    fetchReports();
    fetchAdminsAndStats();
    fetchDebugModeStatus();
  }, [toast, fetchReports]);

  const handleIgnore = async (reportId) => {
    try {
      await adminApi.ignoreReport(reportId);
      toast.success("Report ignored successfully");
      await fetchReports();
    } catch (error) {
      toast.error("Failed to ignore report");
    }
  };

  const handleResolve = async (reportId) => {
    try {
      await adminApi.resolveReport(reportId);
      toast.success("Report resolved successfully");
      await fetchReports();
    } catch (error) {
      toast.error("Failed to resolve report");
    }
  };

  const handleViewMeme = async (memeId) => {
    try {
      const res = await memeApi.getMemeById(memeId);
      setViewedImg(`data:image/png;base64,${res.data.data.meme.result_img}`);
    } catch (error) {
      toast.error("Failed to view meme");
    }
  };

  return (
    <div className="p-4 relative">
      <main className="container mx-auto flex-grow p-4">
        <h1 className="text-2xl font-bold mb-4">
          Welcome to the Admin Dashboard
        </h1>
        {debugBtnVisible && (
          <button
            className="absolute top-8 right-8 px-4 py-2 bg-gray-900 text-white rounded"
            onClick={() => (window.location.href = adminApi.debugModePage)}
          >
            Debugging
          </button>
        )}

        <section className="mb-8">
          <h2 className="text-xl font-semibold mb-2">Admin Profiles</h2>
          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            {admins.map((admin) => (
              <div className="bg-white p-4 shadow-lg rounded-lg" key={admin.id}>
                <h3 className="text-lg font-semibold mb-2">{admin.username}</h3>
                <p>Email: {admin.email}</p>
              </div>
            ))}
          </div>
        </section>
        <section className="mb-8">
          <h2 className="text-xl font-semibold mb-2">User Reports</h2>
          <div className="bg-white p-4 shadow-lg rounded-lg">
            <p>Here you can view and manage user reports.</p>
            <div className="mb-4 flex justify-end">
              <button
                className={`px-4 py-2 rounded mr-2 ${
                  selectedButton === "Pending"
                    ? "bg-gray-900 text-white"
                    : "bg-gray-500 text-white"
                }`}
                onClick={() => setSelectedButton("Pending")}
              >
                Pending
              </button>
              <button
                className={`px-4 py-2 rounded mr-2 ${
                  selectedButton === "Resolved"
                    ? "bg-gray-900 text-white"
                    : "bg-gray-500 text-white"
                }`}
                onClick={() => setSelectedButton("Resolved")}
              >
                Resolved
              </button>
              <button
                className={`px-4 py-2 rounded mr-2 ${
                  selectedButton === "Ignored"
                    ? "bg-gray-900 text-white"
                    : "bg-gray-500 text-white"
                }`}
                onClick={() => setSelectedButton("Ignored")}
              >
                Ignored
              </button>
            </div>
            <div className="overflow-x-auto mt-6">
              <table className="w-full whitespace-nowrap">
                <thead>
                  <tr className="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                    <th className="px-4 py-3">Report ID</th>
                    <th className="px-4 py-3">User Name</th>
                    <th className="px-4 py-3">Report Details</th>
                    <th className="px-4 py-3">Actions</th>
                  </tr>
                </thead>
                <tbody className="bg-white divide-y">
                  {reports
                    .filter(
                      (report) => report.status === selectedButton.toLowerCase()
                    )
                    .map((report) => (
                      <tr className="text-gray-700" key={report.id}>
                        <td className="px-4 py-3">{report.id}</td>
                        <td className="px-4 py-3">{report.user.username}</td>
                        <td className="px-4 py-3">{report.reason}</td>
                        <td className="px-4 py-3">
                          <button
                            className="text-blue-600 hover:text-blue-900 mr-2"
                            onClick={() => {
                              setOpenView(true);
                              handleViewMeme(report.meme_id);
                            }}
                          >
                            View
                          </button>
                          <Modal
                            open={openView}
                            onClose={() => setOpenView(false)}
                            center
                          >
                            <img
                              className="h-96 w-auto object-cover"
                              src={viewedImg}
                              alt="Meme"
                            />
                          </Modal>
                          {selectedButton.toLowerCase() !== "resolved" && (
                            <button
                              className="text-green-600 hover:text-green-900 mr-2"
                              onClick={() => handleResolve(report.id)}
                            >
                              Resolve
                            </button>
                          )}
                          {selectedButton.toLowerCase() !== "ignored" && (
                            <button
                              className="text-red-600 hover:text-red-900"
                              onClick={() => handleIgnore(report.id)}
                            >
                              Ignore
                            </button>
                          )}
                        </td>
                      </tr>
                    ))}
                </tbody>
              </table>
            </div>
          </div>
        </section>
        <section className="mb-8">
          <h2 className="text-xl font-semibold mb-2">Website Statistics</h2>
          <div className="bg-white p-4 shadow-lg rounded-lg">
            <p>Here you can view statistics about the website.</p>
            <div className="grid grid-cols-2 gap-4">
              <div className="p-4 bg-gray-100 rounded-lg">
                <h3 className="font-semibold text-lg">Number of Users</h3>
                <p className="text-gray-500">{stats.totalUsers}</p>
              </div>
              <div className="p-4 bg-gray-100 rounded-lg">
                <h3 className="font-semibold text-lg">Total Memes Posted</h3>
                <p className="text-gray-500">{stats.totalMemes}</p>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
  );
};

export default AdminDashboard;
