import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { NavLink } from 'react-router-dom'
import { logout } from '../slices/userSlice'
import '../styles/header.css'

const Header = () => {
  const { token } = useSelector((state) => state.user)
  const dispatch = useDispatch()

  // automatically authenticate user if token is found
  useEffect(() => {}, [token, dispatch])

  return (
    <header>
      <div className='header-status'>
        <span>
          {token ? `Logged in` : "You're not logged in"}
        </span>
        <div className='cta'>
          {token ? (
            <button className='button' onClick={() => dispatch(logout())}>
              Logout
            </button>
          ) : (
            <NavLink className='button' to='/admin/login'>
              Login
            </NavLink>
          )}
        </div>
      </div>
      <nav className='container navigation'>
        <NavLink to='/admin/home'>Home</NavLink>
        <NavLink to='/admin/login'>Login</NavLink>
          <NavLink to='/admin/spots'>Spots Manager</NavLink>
          <NavLink to='/admin/spot/create'>Create Spot</NavLink>
          <NavLink to='/admin/login'>Login</NavLink>
        <NavLink to='/admin/user-profile'>Profile</NavLink>
      </nav>
    </header>
  )
}

export default Header
