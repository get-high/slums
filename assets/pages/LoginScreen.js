import { useForm } from 'react-hook-form'
import { useNavigate } from 'react-router-dom'
import { useDispatch, useSelector } from 'react-redux'
import { userLogin } from '../actions/userActions'
import React, { useEffect } from 'react'
import Error from '../components/Error'

const LoginScreen = () => {
  const { loading, token, error } = useSelector((state) => state.user)
  const dispatch = useDispatch()

  const { register, handleSubmit } = useForm()

  const navigate = useNavigate()

  // redirect authenticated user to profile screen
  useEffect(() => {
    if (token) {
      navigate('/admin/user-profile')
    }
  }, [navigate, token])

  const submitForm = (data) => {
    dispatch(userLogin(data))
  }

  return (
    <form onSubmit={handleSubmit(submitForm)}>
      {error && <Error>{error}</Error>}
      <div className='form-group'>
        <label htmlFor='email'>Email</label>
        <input
          type='email'
          className='form-input'
          {...register('username')}
          required
        />
      </div>
      <div className='form-group'>
        <label htmlFor='password'>Password</label>
        <input
          type='password'
          className='form-input'
          {...register('password')}
          required
        />
      </div>
      <button type='submit' className='button' disabled={loading}>
        Login
      </button>
    </form>
  )
}

export default LoginScreen
