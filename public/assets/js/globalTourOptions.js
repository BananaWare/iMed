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
      if(tour.getCurrentStep() != tour.steps.length - 1)
      {
        tour.setCurrentStep(tour.steps.length - 1);
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

  if(window.location.pathname.indexOf("doctor") > -1)
  {
    /*
      Dashboard Steps
    */

    //Dashboard Step
    tour.addStep({
      path: "/dashboard/doctor",
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
      path: "/dashboard/doctor",
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
      onShow: function (tour) { 
        $("#sidebar").toggleClass("active");
      },
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
      path: "/dashboard/doctor",
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
      path: "/dashboard/doctor",
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
      onShow: function (tour) {
        $("#sidebar").toggleClass("active");
      },
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
      placement: "bottom",
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
      onShow: function (tour) {
      },
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

    //End secretaries
    tour.addStep({
      path: "/dashboard/doctor/secretaries",
      element: "#patientsSideBar",
      placement: "right",
      title: "Vamos!",
      content: "Presione siguiente para conocer las funciones que le permitirán administrar sus pacientes, o si lo desea puede terminar el tour.",
      //next: 0,
      //prev: 0,
      animation: true,
      container: "body",
      backdrop: false,
      redirect: true,
      reflex: false,
      orphan: false,
      //template: "",
      onShow: function (tour) {
        $("#sidebar").toggleClass("active");
      },
      onShown: function (tour) {},
      onHide: function (tour) {},
      onHidden: function (tour) {},
      onNext: function (tour) {
        redirectTo("/dashboard/doctor/patients");
      },
      onPrev: function (tour) {},
      onPause: function (tour) {},
      onResume: function (tour) {}
    });


  /*
    Patients Tour
  */
    //Main container
    tour.addStep({
      path: "/dashboard/doctor/patients",
      element: "#mainContainer",
      placement: "bottom",
      title: "Administración de pacientes",
      content: "En esta sección podrá administrar sus pacientes, es decir, añadir nuevas o modificar los ya existentes.",
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

    // Add patient
    tour.addStep({
      path: "/dashboard/doctor/patients",
      element: "#addPatientPanel",
      placement: "bottom",
      title: "Añadir paciente",
      content: "Escriba el RUT de la persona para añadirla como paciente usted.",
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

    // List patients
    tour.addStep({
      path: "/dashboard/doctor/patients",
      element: "#listPatientsPanel",
      placement: "top",
      title: "Lista de pacientes",
      content: "Todas las pacientes que usted tiene ligadas se mostrarán en esta tabla.",
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

    // Optiones table patients
    tour.addStep({
      path: "/dashboard/doctor/patients",
      element: "#tableOptions",
      placement: "left",
      title: "Opciones",
      content: "Utilice estos botones para realizar cambios en los pacientes ligadas.",
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

    //End secretaries
    tour.addStep({
      path: "/dashboard/doctor/patients",
      element: "#assignHourSideBar",
      placement: "right",
      title: "Vamos!",
      content: "Presione siguiente para conocer las funciones que le permitirán administrar las horas de sus pacientes, o si lo desea puede terminar el tour.",
      //next: 0,
      //prev: 0,
      animation: true,
      container: "body",
      backdrop: false,
      redirect: true,
      reflex: false,
      orphan: false,
      //template: "",
      onShow: function (tour) {
        $("#sidebar").toggleClass("active");
      },
      onShown: function (tour) {},
      onHide: function (tour) {},
      onHidden: function (tour) {},
      onNext: function (tour) {},
      onPrev: function (tour) {},
      onPause: function (tour) {},
      onResume: function (tour) {}
    });

  /*
    Hours Tour
  */
    //Main container
    tour.addStep({
      path: "/dashboard/doctor/assignHour",
      element: "#mainContainer",
      placement: "bottom",
      title: "Administración de horas",
      content: "En esta sección podrá administrar las horas de sus pacientes, es decir, añadir nuevas o modificar las ya reservadas.",
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

    // Add patient
    tour.addStep({
      path: "/dashboard/doctor/assignHour",
      element: "#calendarPanel",
      placement: "bottom",
      title: "Añadir paciente",
      content: "En este calendario usted puede visualizar las horalibres. Haga click en un día y luego en un intervalo de tiempo para reservar una hora para un paciente.",
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

    //End secretaries
    tour.addStep({
      path: "/dashboard/doctor/assignHour",
      element: "#prescripciontsSideBar",
      placement: "right",
      title: "Vamos!",
      content: "Presione siguiente para conocer las funciones que le permitirán administrar las recetas de sus pacientes, o si lo desea puede terminar el tour.",
      //next: 0,
      //prev: 0,
      animation: true,
      container: "body",
      backdrop: false,
      redirect: true,
      reflex: false,
      orphan: false,
      //template: "",
      onShow: function (tour) {
        $("#sidebar").toggleClass("active");
      },
      onShown: function (tour) {},
      onHide: function (tour) {},
      onHidden: function (tour) {},
      onNext: function (tour) {},
      onPrev: function (tour) {},
      onPause: function (tour) {},
      onResume: function (tour) {}
    });

  /*
    Prescriptions Tour
  */
    //Main container
    tour.addStep({
      path: "/dashboard/doctor/prescriptions",
      element: "#mainContainer",
      placement: "bottom",
      title: "Administración de pacientes",
      content: "En esta sección podrá administrar las recetas de sus pacientes, es decir, añadir nuevas o visualizar las ya existentes.",
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

    // select patient
    tour.addStep({
      path: "/dashboard/doctor/prescriptions",
      element: "#selectPatientPanel",
      placement: "bottom",
      title: "Seleccionar un paciente",
      content: "Escriba el RUT de la persona para visualizar su información.",
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


    tour.addStep({
      path: "/dashboard/doctor/prescriptions",
      element: "#infoPatient",
      placement: "top",
      title: "Antecedentes del paciente",
      content: "Los antecedentes del paciente seleccionado se visualizarán en esta sección.",
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

    // fPatient
    tour.addStep({
      path: "/dashboard/doctor/prescriptions",
      element: "#fPatient",
      placement: "left",
      title: "Ficha del paciente",
      content: "En esta sección encontrará la lista de fichas que se le han hecho al paciente, cada ficha incluye la información de la visita y la receta prescrita.",
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

    //End prescriptions
    tour.addStep({
      path: "/dashboard/doctor/patients",
      element: "#schedulesSideBar",
      placement: "right",
      title: "Vamos!",
      content: "Presione siguiente para conocer las funciones que le permitirán configurar en qué horarios usted trabaja, o si lo desea puede terminar el tour.",
      //next: 0,
      //prev: 0,
      animation: true,
      container: "body",
      backdrop: false,
      redirect: true,
      reflex: false,
      orphan: false,
      //template: "",
      onShow: function (tour) {
        $("#sidebar").toggleClass("active");
      },
      onShown: function (tour) {},
      onHide: function (tour) {},
      onHidden: function (tour) {},
      onNext: function (tour) {},
      onPrev: function (tour) {},
      onPause: function (tour) {},
      onResume: function (tour) {}
    });


  /*
    Schedules Tour
  */
    //Main container
    tour.addStep({
      path: "/dashboard/doctor/schedules",
      element: "#schedulesPanel",
      placement: "bottom",
      title: "Administración de pacientes",
      content: "En esta sección podrá configurar los días y las horas en que usted trabaja.",
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

    //End schedules
    tour.addStep({
      path: "/dashboard/doctor/patients",
      element: "#billingsSideBar",
      placement: "right",
      title: "Vamos!",
      content: "Presione siguiente para conocer las funciones que le permitirán revisar el estado de su subscripción y los pagos realizados, o si lo desea puede terminar el tour.",
      //next: 0,
      //prev: 0,
      animation: true,
      container: "body",
      backdrop: false,
      redirect: true,
      reflex: false,
      orphan: false,
      //template: "",
      onShow: function (tour) {
        $("#sidebar").toggleClass("active");
      },
      onShown: function (tour) {},
      onHide: function (tour) {},
      onHidden: function (tour) {},
      onNext: function (tour) {},
      onPrev: function (tour) {},
      onPause: function (tour) {},
      onResume: function (tour) {}
    });

  /*
    Billings Tour
  */
    //Main container
    tour.addStep({
      path: "/dashboard/doctor/billings",
      element: "#subscriptionState",
      placement: "bottom",
      title: "Estado de la subscripción",
      content: "En esta sección podrá revisar el estado de su subscripción y los días de vigencia.",
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

    tour.addStep({
      path: "/dashboard/doctor/billings",
      element: "#pays",
      placement: "bottom",
      title: "Estado de la subscripción",
      content: "En esta sección podrá revisar los pagos que ha realizado.",
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
  }
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











