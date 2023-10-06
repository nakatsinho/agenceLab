import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'https://2357-197-249-39-194.ngrok-free.app/api/',
  headers: {
    'Content-type': 'application/json'
  }
});

export default axiosInstance;