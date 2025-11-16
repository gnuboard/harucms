const API_URL = 'https://haru.gnuboard.net';

class ApiService {
  async request(endpoint, options = {}) {
    const url = `${API_URL}${endpoint}`;

    const config = {
      ...options,
      credentials: 'include', // 세션 쿠키 포함
      headers: {
        'Content-Type': 'application/json',
        ...options.headers,
      },
    };

    try {
      const response = await fetch(url, config);
      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || 'API 요청 실패');
      }

      return data;
    } catch (error) {
      console.error('API Error:', error);
      throw error;
    }
  }

  // 로그인
  async login(email, password) {
    return this.request('/api/auth/login', {
      method: 'POST',
      body: JSON.stringify({ email, password }),
    });
  }

  // 회원가입
  async signup(email, password, nickname, name = null) {
    return this.request('/api/auth/signup', {
      method: 'POST',
      body: JSON.stringify({ email, password, nickname, name }),
    });
  }

  // 로그아웃
  async logout() {
    return this.request('/api/auth/logout', {
      method: 'POST',
    });
  }

  // 현재 사용자 정보
  async getMe() {
    return this.request('/api/auth/me');
  }

  // 프로필 업데이트
  async updateProfile(data) {
    return this.request('/api/auth/profile', {
      method: 'POST',
      body: JSON.stringify(data),
    });
  }
}

export default new ApiService();
