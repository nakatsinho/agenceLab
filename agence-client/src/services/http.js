import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'https://887b-197-235-254-242.ngrok-free.app/api/',
  headers: {
    'Content-type': 'application/json'
  }
});

export default axiosInstance;