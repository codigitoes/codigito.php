import { Outlet } from "react-router-dom";
import Footer from "./footer/Footer";
import Navbar from "./navbar/Navbar";
import Menu from "./menu/Menu";

export const Layout: React.FC<{}> = ({ }) => {
    return (<div className="main">
        <Navbar />
        <div className="container">
            <div className="menuContainer">
                <Menu />
            </div>
            <div className="contentContainer">
                <Outlet />
            </div>
        </div>
        <Footer />
    </div>)
};
