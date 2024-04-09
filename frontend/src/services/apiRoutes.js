const BASE_URL = process.env.REACT_APP_BASE_URL || "http://localhost:8000/";

const USER_API_ROUTES = {
  CHECK_AUTH: "/checkAuth",
  GET_USER_PROFILE: "/user/:id",
  MODIFY_PASSWORD: "/user/profile/modifyPassword",
  EDIT_PROFILE: "/user/profile/edit",
  DELETE_PROFILE: "/user/profile",
  SEND_VERIF_EMAIL: "/sendVerificationEmail/:username",
  VERIFY_EMAIL: "/verifyEmail",
  FORGOT_PASSWORD: "/forgotPassword/:username",
  RESET_PASSWORD: "/resetPassword",
  VERIFY_TOKEN: "/verifyToken",
};

const MEME_API_ROUTES = {
  GET_ALL_MEMES: "/memes",
  GET_MEME_BY_ID: "/memes/:id",
  GET_USER_MEMES: "/memes/user/:id",
  GET_MEME_LIKES: "/memes/:id/likes",
  ADD_MEME: "/memes",
  MODIFY_MEME: "/memes/:id/modify",
  LIKE_MEME: "/memes/:id/like",
  DISLIKE_MEME: "/memes/:id/dislike",
  REPORT_MEME: "/memes/:id/report",
  DELETE_MEME: "/memes/:id",
};

const TEMPLATE_API_ROUTES = {
  GET_ALL_TEMPLATES: "/templates",
  GET_TEMPLATE_BY_ID: "/templates/:id",
};

const ADMIN_API_ROUTES = {
  GET_ALL_USERS: "/admin/users",
  GET_USER_PROFILE: "/admin/users/:id",
  CHANGE_USER_ROLE: "/admin/users/:id/role",
  DELETE_USER: "/admin/users/:id/delete",
  GET_ALL_REPORTS: "/admin/reports",
  RESOLVE_REPORT: "/admin/reports/:id/resolve",
  IGNORE_REPORT: "/admin/reports/:id/ignore",
  DELETE_REPORT: "/admin/reports/:id/delete",
  DELETE_MEME: "/admin/memes/:id/delete",
  DEBUG_MODE_STATUS: "/admin/devmode",
};

const API_ROUTES = {
  HOME: "/",
  TEST: "/test",
  LOGIN: "/login",
  REGISTER: "/register",
  LOGOUT: "/logout",
  FORGOT_PASSWORD: "/forgotPassword",
  RESET_PASSWORD: "/resetPassword",
  SEND_VERIFICATION_EMAIL: "/sendVerificationEmail",
  VERIFY_EMAIL: "/verifyEmail",
};

export {
  BASE_URL,
  API_ROUTES,
  USER_API_ROUTES,
  MEME_API_ROUTES,
  TEMPLATE_API_ROUTES,
  ADMIN_API_ROUTES,
};

/*

const getUserAuth = () => {
    return axios.get(BASE_URL + USER_API_ROUTES.CHECK_AUTH);
};

const getUserProfile = (userId) => {
    return axios.get(BASE_URL + USER_API_ROUTES.GET_USER_PROFILE.replace(':id', userId));
};

const modifyUserPassword = (passwordData) => {
    return axios.post(BASE_URL + USER_API_ROUTES.MODIFY_PASSWORD, passwordData);
};

const editUserProfile = (userData) => {
    return axios.post(BASE_URL + USER_API_ROUTES.EDIT_PROFILE, userData);
};

const deleteUserProfile = () => {
    return axios.delete(BASE_URL + USER_API_ROUTES.DELETE_PROFILE);
};

const getAllMemes = () => {
    return axios.get(BASE_URL + MEME_API_ROUTES.GET_ALL_MEMES);
};

const getMemeById = (memeId) => {
    return axios.get(BASE_URL + MEME_API_ROUTES.GET_MEME_BY_ID.replace(':id', memeId));
};

const getUserMemes = (userId) => {
    return axios.get(BASE_URL + MEME_API_ROUTES.GET_USER_MEMES.replace(':id', userId));
};

const addMeme = (memeData) => {
    return axios.post(BASE_URL + MEME_API_ROUTES.ADD_MEME, memeData);
};

const likeMeme = (memeId) => {
    return axios.post(BASE_URL + MEME_API_ROUTES.LIKE_MEME.replace(':id', memeId));
};

const dislikeMeme = (memeId) => {
    return axios.post(BASE_URL + MEME_API_ROUTES.DISLIKE_MEME.replace(':id', memeId));
};

const reportMeme = (memeId) => {
    return axios.post(BASE_URL + MEME_API_ROUTES.REPORT_MEME.replace(':id', memeId));
};

const deleteMeme = (memeId) => {
    return axios.delete(BASE_URL + MEME_API_ROUTES.DELETE_MEME.replace(':id', memeId));
};

const getAllTemplates = () => {
    return axios.get(BASE_URL + TEMPLATE_API_ROUTES.GET_ALL_TEMPLATES);
};

const getTemplateById = (templateId) => {
    return axios.get(BASE_URL + TEMPLATE_API_ROUTES.GET_TEMPLATE_BY_ID.replace(':id', templateId));
};

const getAllUsers = () => {
    return axios.get(BASE_URL + ADMIN_API_ROUTES.GET_ALL_USERS);
};

const getUserProfileById = (userId) => {
    return axios.get(BASE_URL + ADMIN_API_ROUTES.GET_USER_PROFILE.replace(':id', userId));
};

const changeUserRole = (userId, roleData) => {
    return axios.post(BASE_URL + ADMIN_API_ROUTES.CHANGE_USER_ROLE.replace(':id', userId), roleData);
};

const deleteUser = (userId) => {
    return axios.post(BASE_URL + ADMIN_API_ROUTES.DELETE_USER.replace(':id', userId));
};

const getAllReports = () => {
    return axios.get(BASE_URL + ADMIN_API_ROUTES.GET_ALL_REPORTS);
};

const resolveReport = (reportId) => {
    return axios.post(BASE_URL + ADMIN_API_ROUTES.RESOLVE_REPORT.replace(':id', reportId));
};

const ignoreReport = (reportId) => {
    return axios.post(BASE_URL + ADMIN_API_ROUTES.IGNORE_REPORT.replace(':id', reportId));
};

const deleteReport = (reportId) => {
    return axios.post(BASE_URL + ADMIN_API_ROUTES.DELETE_REPORT.replace(':id', reportId));
};

const deleteMemeByAdmin = (memeId) => {
    return axios.post(BASE_URL + ADMIN_API_ROUTES.DELETE_MEME.replace(':id', memeId));
};

const home = () => {
    return axios.get(BASE_URL + API_ROUTES.HOME);
};

const test = () => {
    return axios.get(BASE_URL + API_ROUTES.TEST);
};

const login = (loginData) => {
    return axios.post(BASE_URL + API_ROUTES.LOGIN, loginData);
};

const register = (registerData) => {
    return axios.post(BASE_URL + API_ROUTES.REGISTER, registerData);
};

const logout = () => {
    return axios.post(BASE_URL + API_ROUTES.LOGOUT);
};

const forgotPassword = (emailData) => {
    return axios.post(BASE_URL + API_ROUTES.FORGOT_PASSWORD, emailData);
};

const resetPassword = (passwordData) => {
    return axios.post(BASE_URL + API_ROUTES.RESET_PASSWORD, passwordData);
};

const sendVerificationEmail = () => {
    return axios.get(BASE_URL + API_ROUTES.SEND_VERIFICATION_EMAIL);
};

const verifyEmail = () => {
    return axios.get(BASE_URL + API_ROUTES.VERIFY_EMAIL);
};

export {
    getUserAuth,
    getUserProfile,
    modifyUserPassword,
    editUserProfile,
    deleteUserProfile,
    getAllMemes,
    getMemeById,
    getUserMemes,
    addMeme,
    likeMeme,
    dislikeMeme,
    reportMeme,
    deleteMeme,
    getAllTemplates,
    getTemplateById,
    getAllUsers,
    getUserProfileById,
    changeUserRole,
    deleteUser,
    getAllReports,
    resolveReport,
    ignoreReport,
    deleteReport,
    deleteMemeByAdmin,
    home,
    test,
    login,
    register,
    logout,
    forgotPassword,
    resetPassword,
    sendVerificationEmail,
    verifyEmail
};*/
