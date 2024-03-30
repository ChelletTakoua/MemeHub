import axios from 'axios';

import { BASE_URL, USER_API_ROUTES, MEME_API_ROUTES, TEMPLATE_API_ROUTES, ADMIN_API_ROUTES } from './apiRoutes';

// Mathabbattech fehom edhekom houma bedhabt walle el routes
// elli bch t3addi fehom body wala haja ziid 3ala rohek
// hattithom fi nafs el fichier bo5ol w barra ken thb nfar9ohom ama hakka netsawer yekfi


const base = axios.create({
  baseURL: BASE_URL,
});

export const userApi = {
  getUserAuth: () => { return base.get(USER_API_ROUTES['CHECH_AUTH'])},
  getUserProfile: (userId) => base.get(USER_API_ROUTES['GET_USER_PROFILE']).replace(':id', userId),
  modifyUserPassword: (passwordData) => base.post(USER_API_ROUTES['MODIFY_PASSWORD'], passwordData),
  editUserProfile: (userData) => base.post(USER_API_ROUTES['EDIT_PROFILE'], userData),
  deleteUserProfile: () => base.delete(USER_API_ROUTES['DELETE_PROFILE']),
};

export const memeApi = { 
  getAllMemes: () => base.get(MEME_API_ROUTES['GET_ALL_MEMES']),
  getMemeById: (memeId) => base.get(MEME_API_ROUTES['GET_MEME_BY_ID'].replace(':id', memeId)),
  getUserMemes: (userId) => base.get(MEME_API_ROUTES['GET_USER_MEMES'].replace(':id', userId)),
  addMeme: (memeData) => base.post(MEME_API_ROUTES['ADD_MEME'], memeData),
  likeMeme: (memeId) => base.post(MEME_API_ROUTES['LIKE_MEME'].replace(':id', memeId)),
  dislikeMeme: (memeId) => base.post(MEME_API_ROUTES['DISLIKE_MEME'].replace(':id', memeId)),
  reportMeme: (memeId) => base.post(MEME_API_ROUTES['REPORT_MEME'].replace(':id', memeId)),
  deleteMeme: (memeId) => base.delete(MEME_API_ROUTES['DELETE_MEME'].replace(':id', memeId)),
};

export const templateApi = { 
  getAllTemplates: () => base.get(TEMPLATE_API_ROUTES['GET_ALL_TEMPLATES']),
  getTemplateById: (templateId) => base.get(TEMPLATE_API_ROUTES['GET_TEMPLATE_BY_ID'].replace(':id', templateId)),
};

export const adminApi = { 
  getAllUsers: () => base.get(ADMIN_API_ROUTES['GET_ALL_USERS']),
  getUserProfile: (userId) => base.get(ADMIN_API_ROUTES['GET_USER_PROFILE'].replace(':id', userId)),
  changeUserRole: (userId, role) => base.post(ADMIN_API_ROUTES['CHANGE_USER_ROLE'].replace(':id', userId),{ role }),
  deleteUser: (userId) => base.delete(ADMIN_API_ROUTES['DELETE_USER'].replace(':id', userId)), 
  getAllReports: () => base.get(ADMIN_API_ROUTES['GET_ALL_REPORTS']),
  resolveReport: (reportId) => base.post(ADMIN_API_ROUTES['RESOLVE_REPORT'].replace(':id', reportId)),
  ignoreReport: (reportId) => base.post(ADMIN_API_ROUTES['IGNORE_REPORT'].replace(':id', reportId)),
  deleteReport: (reportId) => base.delete(ADMIN_API_ROUTES['DELETE_REPORT'].replace(':id', reportId)),
  deleteMeme: (memeId) => base.delete(ADMIN_API_ROUTES['DELETE_MEME'].replace(':id', memeId)),
};