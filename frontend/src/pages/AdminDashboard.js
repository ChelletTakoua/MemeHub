import React, { useState } from "react";

const AdminDashboard = () => {
  const [selectedButton, setSelectedButton] = useState("Pending");
  const [reports, setReports] = useState([
    {
      id: 1,
      userName: "John Doe",
      details: "Inappropriate content",
    },
    {
      id: 2,
      userName: "Jane Doe",
      details: "Spam",
    },
  ]);

  const handleDelete = (reportId) => {
    setReports(reports.filter((report) => report.id !== reportId));
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
                  {reports.map((report) => (
                    <tr className="text-gray-700" key={report.id}>
                      <td className="px-4 py-3">{report.id}</td>
                      <td className="px-4 py-3">{report.userName}</td>
                      <td className="px-4 py-3">{report.details}</td>
                      <td className="px-4 py-3">
                        <button className="text-blue-600 hover:text-blue-900 mr-2">
                          View
                        </button>
                        <button className="text-green-600 hover:text-green-900 mr-2">
                          Resolve
                        </button>
                        <button
                          className="text-red-600 hover:text-red-900"
                          onClick={() => handleDelete(report.id)}
                        >
                          Ignore
                        </button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </section>
        <section class="mb-8">
          <h2 class="text-xl font-semibold mb-2">Website Statistics</h2>
          <div class="bg-white p-4 shadow-lg rounded-lg">
            <p>Here you can view statistics about the website.</p>
            <div class="grid grid-cols-2 gap-4">
              <div class="p-4 bg-gray-100 rounded-lg">
                <h3 class="font-semibold text-lg">Number of Users</h3>
                <p class="text-gray-500">12345</p>
              </div>
              <div class="p-4 bg-gray-100 rounded-lg">
                <h3 class="font-semibold text-lg">Total Memes Posted</h3>
                <p class="text-gray-500">67890</p>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
  );
};

export default AdminDashboard;
