

function Hero() {
  return (
    <div className="relative h-[300px] bg-cover bg-center" style={{backgroundImage: "url('/images/fachada.jpeg')", backgroundAttachment:"fixed"}}>
       
        <div className="absolute inset-0 bg-black bg-opacity-50"></div>
        
        
        <div className="relative z-10 flex flex-col items-center justify-center h-full text-center text-white py-3">
            <img src="images/escudo.png" className="h-40 w-30" alt=""/>
            <h1 className="text-4xl md:text-3xl font-bold">Sistema de Control de Gastos de la Cooperadora Escolar</h1>
            <p className="mt-4 text-lg md:text-2xl">EET 3107 Juana Azurduy de Padilla</p>
        
        </div>
    </div>
  )
}

export default Hero