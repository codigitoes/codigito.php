import React from 'react';
import './navbar.scss';

interface NavbarProps {
}

const Navbar: React.FC<NavbarProps> = ({ }) => {
    return (
        <>
            <div className='navbar'>
                <div className="logo">
                    <img src='/logo.svg' alt="" />
                    <span>codigito.admin</span>
                </div>
                <div className="icons">
                    {/* <img src="/search.svg" alt="" className="icon" />
                    <img src="/app.svg" alt="" className="icon" />
                    <img src="/expand.svg" alt="" className="icon" /> */}
                    {/* <div className="notification">
                        <img src="/notifications.svg" alt="" className="icon" />
                        <span>1</span>
                    </div> */}
                    {/* <div className="user">
                        <img src="https://images.pexels.com/photos/11038549/pexels-photo-11038549.jpeg?auto=compress&cs=tinysrgb&w=1600&lazy=load" alt="" className="icon" />
                        <span>markitos</span>
                    </div>
                    <img src="/settings.svg" alt="" className="icon" /> */}
                    <div className="user">
                        <img src="/login.png" alt="login" className="icon" />
                        <span>login</span>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Navbar;
