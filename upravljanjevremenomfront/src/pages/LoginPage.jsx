import { useState } from "react";
import { useNavigate } from "react-router-dom";
import Button from "../components/Button";
import Input from "../components/Input";
import "./LoginPage.css";

function LoginPage({ onLogin }) {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const navigate = useNavigate();
  const handleLogin = () => {
    // ovde ide fetch ka backendu
    console.log("Login:", email, password);
    if(onLogin) 
      onLogin(email);
      navigate("/home");
  };

  return (
    <div className="login-container">
      <h2>Login</h2>
      <div className="login-form">
        <Input type="email" value={email} onChange={(e) => setEmail(e.target.value)} placeholder="Email" />
        <Input type="password" value={password} onChange={(e) => setPassword(e.target.value)} placeholder="Lozinka" />
        <Button text="Prijavi se" onClick={handleLogin} type="primary" />
      </div>
    </div>
  );
}

export default LoginPage;

