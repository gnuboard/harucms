import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../services/api';

function Home() {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    checkAuth();
  }, []);

  const checkAuth = async () => {
    try {
      const response = await api.getMe();
      setUser(response.data.user);
    } catch (error) {
      console.error('인증 확인 실패:', error);
      navigate('/login');
    } finally {
      setLoading(false);
    }
  };

  const handleLogout = async () => {
    try {
      await api.logout();
      navigate('/login');
    } catch (error) {
      console.error('로그아웃 실패:', error);
    }
  };

  if (loading) {
    return (
      <div style={styles.container}>
        <div style={styles.loading}>로딩 중...</div>
      </div>
    );
  }

  return (
    <div style={styles.container}>
      <div style={styles.header}>
        <h1 style={styles.logo}>HaruCMS</h1>
        <button onClick={handleLogout} style={styles.logoutBtn}>
          로그아웃
        </button>
      </div>

      <div style={styles.content}>
        <div style={styles.welcomeCard}>
          <h2 style={styles.welcomeTitle}>환영합니다! 👋</h2>

          {user && (
            <div style={styles.userInfo}>
              <div style={styles.infoRow}>
                <span style={styles.infoLabel}>이름:</span>
                <span style={styles.infoValue}>{user.name || '미등록'}</span>
              </div>
              <div style={styles.infoRow}>
                <span style={styles.infoLabel}>이메일:</span>
                <span style={styles.infoValue}>{user.email}</span>
              </div>
              <div style={styles.infoRow}>
                <span style={styles.infoLabel}>권한:</span>
                <span style={styles.infoValue}>
                  {user.is_admin ? '관리자' : '일반 사용자'}
                </span>
              </div>
              {user.last_login && (
                <div style={styles.infoRow}>
                  <span style={styles.infoLabel}>마지막 로그인:</span>
                  <span style={styles.infoValue}>
                    {new Date(user.last_login).toLocaleString('ko-KR')}
                  </span>
                </div>
              )}
            </div>
          )}
        </div>

        <div style={styles.featuresGrid}>
          <div style={styles.featureCard}>
            <h3 style={styles.featureTitle}>게시판</h3>
            <p style={styles.featureDesc}>자유롭게 글을 작성하고 공유하세요</p>
          </div>

          <div style={styles.featureCard}>
            <h3 style={styles.featureTitle}>프로필</h3>
            <p style={styles.featureDesc}>내 정보를 관리하세요</p>
          </div>

          {user?.is_admin && (
            <div style={styles.featureCard}>
              <h3 style={styles.featureTitle}>관리자</h3>
              <p style={styles.featureDesc}>사이트 관리 기능</p>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}

const styles = {
  container: {
    minHeight: '100vh',
    backgroundColor: '#f5f5f5',
  },
  header: {
    backgroundColor: 'white',
    padding: '20px 40px',
    boxShadow: '0 2px 4px rgba(0,0,0,0.1)',
    display: 'flex',
    justifyContent: 'space-between',
    alignItems: 'center',
  },
  logo: {
    margin: 0,
    color: '#007bff',
  },
  logoutBtn: {
    padding: '10px 20px',
    backgroundColor: '#dc3545',
    color: 'white',
    border: 'none',
    borderRadius: '4px',
    cursor: 'pointer',
    fontSize: '14px',
  },
  content: {
    maxWidth: '1200px',
    margin: '0 auto',
    padding: '40px 20px',
  },
  loading: {
    textAlign: 'center',
    padding: '100px',
    fontSize: '18px',
    color: '#666',
  },
  welcomeCard: {
    backgroundColor: 'white',
    padding: '30px',
    borderRadius: '8px',
    boxShadow: '0 2px 10px rgba(0,0,0,0.1)',
    marginBottom: '30px',
  },
  welcomeTitle: {
    marginTop: 0,
    marginBottom: '20px',
    color: '#333',
  },
  userInfo: {
    display: 'flex',
    flexDirection: 'column',
    gap: '15px',
  },
  infoRow: {
    display: 'flex',
    gap: '10px',
  },
  infoLabel: {
    fontWeight: '600',
    color: '#555',
    minWidth: '120px',
  },
  infoValue: {
    color: '#333',
  },
  featuresGrid: {
    display: 'grid',
    gridTemplateColumns: 'repeat(auto-fit, minmax(250px, 1fr))',
    gap: '20px',
  },
  featureCard: {
    backgroundColor: 'white',
    padding: '30px',
    borderRadius: '8px',
    boxShadow: '0 2px 10px rgba(0,0,0,0.1)',
    transition: 'transform 0.2s',
    cursor: 'pointer',
  },
  featureTitle: {
    marginTop: 0,
    marginBottom: '10px',
    color: '#007bff',
  },
  featureDesc: {
    margin: 0,
    color: '#666',
    fontSize: '14px',
  },
};

export default Home;
