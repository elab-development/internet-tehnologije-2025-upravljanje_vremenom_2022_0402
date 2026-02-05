import React from 'react'
import { Link } from 'react-router-dom'

const Navbar = () => {
  return (
    <div>
        <Link to="/" className="href">Pocetna</Link>
        <Link to="/" className="href">Login</Link>
    </div>
  )
}

export default Navbar