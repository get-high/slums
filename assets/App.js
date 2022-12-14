import React from 'react'
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom'
import Header from './components/Header'
import LoginScreen from './pages/LoginScreen'
import ProfileScreen from './pages/ProfileScreen'
import HomeScreen from './pages/HomeScreen'
import ProtectedRoute from './routing/ProtectedRoute'
import CreateSpot from "./pages/CreateSpot";
import EditSpot from "./pages/EditSpot";
import Spots from "./pages/Spots";
import './styles/App.css'

function App() {
    return (
        <Router>
            <Header />
            <main className='container content'>
                <Routes>
                    <Route path='/admin/login' element={<LoginScreen />} />
                    <Route element={<ProtectedRoute />}>
                        <Route path='admin/spots' element={<Spots />} />
                        <Route path='admin/spots/create' element={<CreateSpot />} />
                        <Route path='admin/spots/:id' element={<EditSpot />} />
                        <Route path='admin/user-profile' element={<ProfileScreen />} />
                        <Route path='admin/home' element={<HomeScreen />} />
                    </Route>
                </Routes>
            </main>
        </Router>
    )
}

export default App
