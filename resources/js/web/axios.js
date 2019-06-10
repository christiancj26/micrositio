// Response interceptor
axios.interceptors.response.use((response) => {
    return response;
  },(error) => {
    if (error.response.status === 401) {
        window.location.href = '/login';
        return;
    }
    return Promise.reject(error);
});
