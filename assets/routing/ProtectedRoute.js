import { useSelector } from 'react-redux'
import { NavLink, Outlet } from 'react-router-dom'
import React from 'react'

const ProtectedRoute = () => {
  const { userInfo } = useSelector((state) => state.user)

  // show unauthorized screen if no user is found in redux store
  if (!userInfo) {
    return (
      <div className='unauthorized'>
        <h1>Unauthorized :(</h1>
        <span>
          <NavLink to='/admin/login'>Login</NavLink> to gain access
        </span>
      </div>
    )
  }

  return <Outlet />
}

export default ProtectedRoute
