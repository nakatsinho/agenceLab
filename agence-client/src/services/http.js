import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'https://527c-197-235-53-177.ngrok-free.app/api/',
  headers: {
    'Content-type': 'application/json'
  }
});

export default axiosInstance;