import { useState } from "react";
import { useNavigate } from "react-router-dom";
import Button from "../components/Button";
import Input from "../components/Input";
import "./LoginPage.css";
import { users } from "../data/users";

function LoginPage({ onLogin }) {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const navigate = useNavigate();

  const handleLogin = () => {
  // tražimo korisnika po emailu i passwordu
  const user = users.find(
    (u) => u.email === email && u.password === password
  );

  if (user) {
    // sačuvaj korisnika u localStorage
    localStorage.setItem("currentUser", JSON.stringify(user));
   
    // pozovi onLogin callback ako postoji
    if (onLogin) onLogin(user);

    // idi na home stranicu
    navigate("/home");
  } else {
    setError("Pogrešan email ili lozinka");
  }
  };

  return (
    <div className="login-container">
      <h2>Login</h2>
      <div className="login-form">
        <Input type="email" value={email} onChange={(e) => setEmail(e.target.value)} placeholder="Email" />
        <Input type="password" value={password} onChange={(e) => setPassword(e.target.value)} placeholder="Lozinka" />
        <Button text="Prijavi se" onClick={handleLogin} type="primary" />
        {error && <p className="login-error">{error}</p>}
      </div>
    </div>
  );
}

export default LoginPage;

