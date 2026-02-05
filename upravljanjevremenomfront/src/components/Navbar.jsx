import { useNavigate } from "react-router-dom";
import "./Navbar.css";

function Navbar({ user, onLogout }) {
  const navigate = useNavigate();

  return (
    <nav className="navbar">
      <div className="navbar-left">
        <h2 className="navbar-logo" onClick={() => navigate("/home")}>MyTasksApp</h2>
      </div>

      <div className="navbar-right">
        <button onClick={() => navigate("/home")}>Početna</button>
        <button onClick={() => navigate("/beleske")}>Beleške</button>
        <button onClick={() => navigate("/zadaci")}>Zadaci</button>
        <button onClick={() => navigate("/podsetnik")}>Podsetnik</button>
        <button onClick={() => navigate("/obavestenja")}>Obaveštenja</button>
        <button onClick={() => navigate("/statistika")}>Statistika</button>
        {user && <button onClick={onLogout}>Logout</button>}
      </div>
    </nav>
  );
}

export default Navbar;
