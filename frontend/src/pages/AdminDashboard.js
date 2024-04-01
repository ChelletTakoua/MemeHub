import React, { useContext, useEffect, useState } from "react";
import { AppContext } from "../context/AppContext";
import { adminApi } from "../services/api";

const AdminDashboard = () => {
  const [selectedButton, setSelectedButton] = useState("Pending");
  const [reports, setReports] = useState([]);

  const { toast } = useContext(AppContext);

  useEffect(() => {
    const fetchReports = async () => {
      try {
        const res = await adminApi.getAllReports();
        setReports(res.data.data.reports);
      } catch (error) {
        console.error("Error fetching data:", error);
        toast.error("Failed to fetch reports");
      }
    };
    fetchReports();
  }, [toast]);

  const handleIgnore = async (reportId) => {
    try {
      await adminApi.ignoreReport(reportId);
      toast.success("Report ignored successfully");
    } catch (error) {
      toast.error("Failed to ignore report");
    }
  };

  const handleResolve = async (reportId) => {
    try {
      await adminApi.resolveReport(reportId);
      toast.success("Report resolved successfully");
    } catch (error) {
      toast.error("Failed to resolve report");
    }
  };

  return (
    <div className="">
      <main className="container mx-auto flex-grow p-4">
        <h1 className="text-2xl font-bold mb-4">
          Welcome to the Admin Dashboard
        </h1>

        <section className="mb-8">
          <h2 className="text-xl font-semibold mb-2">Admin Profiles</h2>
          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div className="bg-white p-4 shadow-lg rounded-lg">
              <h3 className="text-lg font-semibold mb-2">Admin Name</h3>
              <p>Email: admin@example.com</p>
            </div>
            <div className="bg-white p-4 shadow-lg rounded-lg">
              <h3 className="text-lg font-semibold mb-2">Admin Name</h3>
              <p>Email: admin@example.com</p>
            </div>
            <div className="bg-white p-4 shadow-lg rounded-lg">
              <h3 className="text-lg font-semibold mb-2">Admin Name</h3>
              <p>Email: admin@example.com</p>
            </div>
            <div className="bg-white p-4 shadow-lg rounded-lg">
              <h3 className="text-lg font-semibold mb-2">Admin Name</h3>
              <p>Email: admin@example.com</p>
            </div>
            <div className="bg-white p-4 shadow-lg rounded-lg">
              <h3 className="text-lg font-semibold mb-2">Admin Name</h3>
              <p>Email: admin@example.com</p>
            </div>
            <div className="bg-white p-4 shadow-lg rounded-lg">
              <h3 className="text-lg font-semibold mb-2">Admin Name</h3>
              <p>Email: admin@example.com</p>
            </div>
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
                        {selectedButton.toLowerCase() === "pending" && (
                          <td className="px-4 py-3">
                            <button className="text-blue-600 hover:text-blue-900 mr-2">
                              View
                            </button>
                            <button
                              className="text-green-600 hover:text-green-900 mr-2"
                              onClick={() => handleResolve(report.id)}
                            >
                              Resolve
                            </button>
                            <button
                              className="text-red-600 hover:text-red-900"
                              onClick={() => handleIgnore(report.id)}
                            >
                              Ignore
                            </button>
                          </td>
                        )}
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
                <p className="text-gray-500">12345</p>
              </div>
              <div className="p-4 bg-gray-100 rounded-lg">
                <h3 className="font-semibold text-lg">Total Memes Posted</h3>
                <p className="text-gray-500">67890</p>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
  );
};

export default AdminDashboard;
