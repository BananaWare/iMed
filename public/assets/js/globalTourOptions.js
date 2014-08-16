var tour;
$(function () {

  tour = new Tour({
    name: "tour",
    steps: [],
    container: "body",
    keyboard: true,
    storage: false,//window.localStorage,
    debug: false,
    backdrop: false,
    redirect: true,
    orphan: false,
    duration: false,
    basePath: "",
    template: "<div class='popover tour'> \
      <div class='arrow'></div> \
      <h3 class='popover-title'> \
      </h3> \
      <div class='popover-content'></div> \
      <div class='popover-navigation pull-left'> \
        <button class='btn btn-danger pull-left' data-role='end'><span class='glyphicon glyphicon-remove'></span></button> \
      </div> \
      <div class='popover-navigation pull-right'> \
          <button class='btn btn-primary' data-role='prev'>«</button> \
          <span data-role='separator'>|</span> \
          <button class='btn btn-primary' data-role='next'>»</button> \
      </div> \
      </nav> \
    </div>",
    afterGetState: function (key, value) {},
    afterSetState: function (key, value) {},
    afterRemoveState: function (key, value) {},
    onStart: function (tour) {},
    onEnd: function (tour) {   
      if(tour.getCurrentStep() != 3)
      {
        tour.setCurrentStep(3);
        tour.start(true); 
      }
    },
    onShow: function (tour) {},
    onShown: function(tour) {
    },
    onHide: function (tour) {},
    onHidden: function (tour) {},
    onNext: function (tour) {},
    onPrev: function (tour) {},
    onPause: function (tour, duration) {},
    onResume: function (tour, duration) {}
  });
  
  /*
    Dashboard Steps
  */

  //Dashboard Step
  tour.addStep({
    path: "",
    element: "#dashboard",
    placement: "bottom",
    title: "Bienvenido",
    content: "Este es su escritorio, desde aquí podrá administrar sus pacientes.",
    //next: 0,
    //prev: 0,
    animation: true,
    container: "body",
    backdrop: true,
    redirect: true,
    reflex: false,
    orphan: false,
    //template: "",
    onShow: function (tour) {},
    onShown: function (tour) {},
    onHide: function (tour) {},
    onHidden: function (tour) {},
    onNext: function (tour) {},
    onPrev: function (tour) {},
    onPause: function (tour) {},
    onResume: function (tour) {}
  });

  //Functions
  tour.addStep({
    path: "",
    element: "#functions",
    placement: "right",
    title: "Funciones",
    content: "En este panel encontrará las funciones necesarias para hacer su trabajo.",
    //next: 0,
    //prev: 0,
    animation: true,
    container: "body",
    backdrop: true,
    redirect: true,
    reflex: false,
    orphan: false,
    //template: "",
    onShow: function (tour) {},
    onShown: function (tour) {},
    onHide: function (tour) {},
    onHidden: function (tour) {},
    onNext: function (tour) {},
    onPrev: function (tour) {},
    onPause: function (tour) {},
    onResume: function (tour) {}
  });

  //Functions
  tour.addStep({
    path: "",
    element: "#hospitalsFormContainer",
    placement: "bottom",
    title: "Puesto de trabajo",
    content: "Este es el lugar donde usted actualmente está trabajando. Si trabaja en múltiples consultas, puede cambiar esta opción en cualquier momento para así poder administrar el que desee. El sistema muestra solo la información de pacientes y secretarias de la consulta que se encuentra actualmente seleccionada",
    //next: 0,
    //prev: 0,
    animation: true,
    container: "body",
    backdrop: true,
    redirect: true,
    reflex: false,
    orphan: false,
    //template: "",
    onShow: function (tour) {},
    onShown: function (tour) {},
    onHide: function (tour) {},
    onHidden: function (tour) {},
    onNext: function (tour) {},
    onPrev: function (tour) {},
    onPause: function (tour) {},
    onResume: function (tour) {}
  });

  //Functions secretaries
  tour.addStep({
    path: "",
    element: "#secretariesSideBar",
    placement: "right",
    title: "Vamos!",
    content: "Presione siguiente para conocer las funciones que le permitirán administrar sus secretarias, o si lo desea puede terminar el tour.",
    //next: 0,
    //prev: 0,
    animation: true,
    container: "body",
    backdrop: false,
    redirect: true,
    reflex: false,
    orphan: false,
    //template: "",
    onShow: function (tour) {},
    onShown: function (tour) {},
    onHide: function (tour) {},
    onHidden: function (tour) {},
    onNext: function (tour) {},
    onPrev: function (tour) {},
    onPause: function (tour) {},
    onResume: function (tour) {}
  });

/*
  Secretary Steps
*/

  //Main container
  tour.addStep({
    path: "/dashboard/doctor/secretaries",
    element: "#mainContainer",
    placement: "left",
    title: "Administración de secretarias",
    content: "En esta sección podrá administrar sus secretarias, es decir, añadir nuevas o quitar las ya existentes.",
    //next: 0,
    //prev: 0,
    animation: true,
    container: "body",
    backdrop: true,
    redirect: true,
    reflex: false,
    orphan: false,
    //template: "",
    onShow: function (tour) {},
    onShown: function (tour) {},
    onHide: function (tour) {},
    onHidden: function (tour) {},
    onNext: function (tour) {},
    onPrev: function (tour) {},
    onPause: function (tour) {},
    onResume: function (tour) {}
  });

  // Add secretary
  tour.addStep({
    path: "/dashboard/doctor/secretaries",
    element: "#addSecretaryPanel",
    placement: "bottom",
    title: "Añadir secretaria",
    content: "Escriba el RUT de la persona para ligarla a usted.",
    //next: 0,
    //prev: 0,
    animation: true,
    container: "body",
    backdrop: true,
    redirect: true,
    reflex: false,
    orphan: false,
    //template: "",
    onShow: function (tour) {},
    onShown: function (tour) {},
    onHide: function (tour) {},
    onHidden: function (tour) {},
    onNext: function (tour) {},
    onPrev: function (tour) {},
    onPause: function (tour) {},
    onResume: function (tour) {}
  });

  // Listar secretary
  tour.addStep({
    path: "/dashboard/doctor/secretaries",
    element: "#listSecretariesPanel",
    placement: "top",
    title: "Lista de secretarias",
    content: "Todas las secretarias que usted tiene ligadas se mostrarán en esta tabla.",
    //next: 0,
    //prev: 0,
    animation: true,
    container: "body",
    backdrop: true,
    redirect: true,
    reflex: false,
    orphan: false,
    //template: "",
    onShow: function (tour) {},
    onShown: function (tour) {},
    onHide: function (tour) {},
    onHidden: function (tour) {},
    onNext: function (tour) {},
    onPrev: function (tour) {},
    onPause: function (tour) {},
    onResume: function (tour) {}
  });

  // Optiones table secretaries
  tour.addStep({
    path: "/dashboard/doctor/secretaries",
    element: "#tableOptions",
    placement: "left",
    title: "Opciones",
    content: "Utilice estos botones para realizar cambios en las secretarias ligadas.",
    //next: 0,
    //prev: 0,
    animation: true,
    container: "body",
    backdrop: true,
    redirect: true,
    reflex: false,
    orphan: false,
    //template: "",
    onShow: function (tour) {},
    onShown: function (tour) {},
    onHide: function (tour) {},
    onHidden: function (tour) {},
    onNext: function (tour) {},
    onPrev: function (tour) {},
    onPause: function (tour) {},
    onResume: function (tour) {}
  });

  //Close
  tour.addStep({
    path: "",
    element: "#helpMe",
    placement: "bottom",
    title: "Ayuda",
    content: "¡Una cosa más! Utilice este botón si tiene dudas con alguna funcionalidad.",
    //next: 0,
    //prev: 0,
    animation: true,
    container: "body",
    backdrop: true,
    redirect: true,
    reflex: false,
    orphan: false,
    //template: "",
    onShow: function (tour) {},
    onShown: function (tour) {},
    onHide: function (tour) {},
    onHidden: function (tour) {},
    onNext: function (tour) {},
    onPrev: function (tour) {},
    onPause: function (tour) {},
    onResume: function (tour) {}
  });

});













