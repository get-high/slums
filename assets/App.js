import React from 'react'
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom'
import Header from './components/Header'
import LoginScreen from './pages/LoginScreen'
import RegisterScreen from './pages/RegisterScreen'
import ProfileScreen from './pages/ProfileScreen'
import HomeScreen from './pages/HomeScreen'
import ProtectedRoute from './routing/ProtectedRoute'
import './styles/App.css'

function App() {
  return (
    <Router>
      <Header />
      <main className='container content'>
        <Routes>
          <Route path='/admin' element={<HomeScreen />} />
          <Route path='/admin/login' element={<LoginScreen />} />
          <Route path='/admin/register' element={<RegisterScreen />} />
          <Route element={<ProtectedRoute />}>
            <Route path='admin/user-profile' element={<ProfileScreen />} />
          </Route>
        </Routes>
      </main>
    </Router>
  )
}

export default App
