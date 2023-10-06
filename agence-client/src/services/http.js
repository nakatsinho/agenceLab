import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'https://d3f5-197-235-250-140.ngrok-free.app/api/',
  headers: {
    'Content-type': 'application/json'
  }
});

export default axiosInstance;