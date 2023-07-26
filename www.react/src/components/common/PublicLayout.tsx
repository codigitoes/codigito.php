import PublicHeader from "./PublicHeader";
import NavBar from "./NavBar";
import { Outlet } from "react-router-dom";

const PublicLayout:React.FC<unknown> = () => {
    return (
        <>
        <NavBar/>
        <PublicHeader title='codigito.es' description='el camino del test'/>
        <Outlet/>
        </>
    );
}

export default PublicLayout;